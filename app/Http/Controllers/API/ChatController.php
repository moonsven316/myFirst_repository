<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\NotificationController;

use App\Http\Controllers\WorkerController;
use App\Models\Applicant;
use App\Models\Favourite;
use App\Models\Message;
use App\Models\Recruitment;
use App\Models\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class ChatController extends BaseController
{
    public $pusher;
    public function __construct()
    {
        $this->middleware('auth');

        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            array('cluster' => env('PUSHER_APP_CLUSTER'))
        );
    }

    public function get_recruitments(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();

        if($user['role'] == 'producer') {
            $recruitments = Recruitment::where('producer_id', $user['id'])
                ->orderByDesc('_recruitments.updated_at')
                ->get();
        }
        else {
            $recruitments = Applicant::join('_recruitments', '_recruitments.id', '=', '_applicants.recruitment_id')
                ->select('_applicants.id as applicant_id', '_applicants.*', '_recruitments.*')
                ->where('_applicants.worker_id', $user['id'])
                ->orderByDesc('_recruitments.updated_at')
                ->get();
        }

        return $this->sendResponse($recruitments, 'recruitments data');
    }

    public function get_favourites(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();

        if($user->role == 'producer') {
            $favourites = Favourite::join('users', 'users.id', '=', '_favourites.favourite_id')
                ->select('users.id as id', 'users.*', '_favourites.*')
                ->where('user_id', $user->id)
                ->get();
        }
        else {
            $recruitment_id_array = Applicant::where('worker_id', $user->id)
                ->pluck('recruitment_id')->toArray();
            $recruitment_id_array = array_unique($recruitment_id_array);

            $producer_id_array = Recruitment::whereIn('id', $recruitment_id_array)->pluck('producer_id')->toArray();
            $producer_id_array = array_unique($producer_id_array);

            $favourites = User::whereIn('id', $producer_id_array)->get();
        }

        return $this->sendResponse($favourites, 'favourites data');
    }

    public function get_unread_messages(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();

        $messages = Message::where('receiver_id', $user->id)
            ->where('owner_id', $user->id)
            ->where('read', 0)
            ->get();

        foreach ($messages as $msg) {
            $msg['sender'] = User::find($msg['sender_id']);
        }

        return $this->sendResponse($messages, '$messages data');
    }

    public function get_applicants(Request $request, $recruitment_id): JsonResponse
    {
        $user = auth('sanctum')->user();

        if($user['role'] == 'producer') {
            $applicants = Applicant::join('users', 'users.id', '=', '_applicants.worker_id')
                ->select('users.*', '_applicants.*', '_applicants.id as applicant_id')
                ->where('_applicants.recruitment_id', $recruitment_id)
                ->get();
            return $this->sendResponse($applicants, 'applicants data');
        }
        else {
            return $this->sendResponse([], 'empty applicants data because you are not producer');
        }
    }

    public function get_info(Request $request, $recruitment_id, $receiver_id): JsonResponse
    {
        $user = auth('sanctum')->user();

        $receiver = User::find($receiver_id);

        $data = [
            'receiver' => $receiver,
            'recruitment_id' => $recruitment_id,
            'sender_id' => $user['id']
        ];

        return $this->sendResponse($data, 'receiver, recruitment_id');
    }

    public function get_messages(Request $request): JsonResponse
    {
        $user = auth('sanctum')->user();
        $sender_id = $request->input('sender_id');
        $skip = $request->input('skip');
        $limit = $request->input('limit');
        $recruitment_id = $request->input('recruitment_id');

        $messages = Message::orWhere(function($query) use ($sender_id, $user, $recruitment_id) {
            $query->where('sender_id', $sender_id)
                ->where('recruitment_id', $recruitment_id)
                ->where('receiver_id', $user['id'])
                ->where('owner_id', $user['id']);
        })
            ->orWhere(function($query) use ($sender_id, $user, $recruitment_id) {
                $query->where('receiver_id', $sender_id)
                    ->where('recruitment_id', $recruitment_id)
                    ->where('sender_id', $user['id'])
                    ->where('owner_id', $user['id']);
            })
            ->orderBy('created_at', 'desc')
            ->skip($skip)
            ->take($limit);

        foreach ($messages->get() as $message) {
            if(!$message['read']) {
                $this->pusher->trigger('chat', 'read-message', $message['message_id']);
            }
        }

        $messages->update(['read' => 1]);

        $msg = [];

        foreach ($messages->orderBy('created_at')->get() as $message) {
            $message['sender'] = User::find($message['sender_id']);
            array_push($msg, $message);
        }

        return $this->sendResponse($msg, 'message data');
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate(
            [
                'receiver_id' => 'required',
                'message' => 'required',
                'message_id' => 'required',
                'recruitment_id' => 'required',
            ],
            [
                'required' => 'この項目は必須です。',
            ]
        );

        $data = $request->all();

        $user = auth('sanctum')->user();

        $message_id = Message::max('message_id') + 1;

        $send_message = Message::create([
            'sender_id' => $user['id'],
            'receiver_id' => $data['receiver_id'],
            'owner_id' => $user['id'],
            'recruitment_id' => $data['recruitment_id'],
            'read' => 1,
            'message_id' => $message_id,
            'message' => $data['message'],
        ]);
        $send_message['sending_id'] = $data['message_id'];

        $receive_message = Message::create([
            'sender_id' => $user['id'],
            'receiver_id' => $data['receiver_id'],
            'owner_id' => $data['receiver_id'],
            'recruitment_id' => $data['recruitment_id'],
            'message_id' => $message_id,
            'message' => $data['message'],
        ]);
        $receive_message['sender'] = $user;
        $this->pusher->trigger('chat', 'receive-'.$data['receiver_id'], $receive_message);

        return $this->sendResponse($send_message, 'message send successful');
    }

    public function deleteMessages(Request $request, $recruitment_id, $receiver_id)
    {
        $user = auth('sanctum')->user();

        $messages = Message::orWhere(function($query) use ($user, $recruitment_id, $receiver_id) {
            $query->where('sender_id', $receiver_id)
                ->where('recruitment_id', $recruitment_id)
                ->where('receiver_id', $user['id'])
                ->where('owner_id', $user['id']);
        })
            ->orWhere(function($query) use ($user, $recruitment_id, $receiver_id) {
                $query->where('receiver_id', $receiver_id)
                    ->where('recruitment_id', $recruitment_id)
                    ->where('sender_id', $user['id'])
                    ->where('owner_id', $user['id']);
            })
            ->delete();

        return $this->sendResponse($messages, 'delete success');
    }

    public function readMessage(Request $request)
    {
        $data = $request->all();
        $message = Message::where('message_id', $data['message_id'])
            ->update(['read' => 1]);
        $this->pusher->trigger('chat', 'read-message', $data['message_id']);

        return $this->sendResponse($message, 'read success');
    }
}
