<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\WorkerController;
use App\Models\Applicant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Image;

use App\Models\User;
use App\Models\Recruitment;

class ApplicationController extends BaseController
{
    public function get(Request $request): JsonResponse
    {
        $userData = auth('sanctum')->user();
        $data = $request->all();
        $conditions = $data['conditions'];

        if(count($conditions) == 0) {
            $recruitments = Applicant::join('_recruitments', '_recruitments.id', '=', '_applicants.recruitment_id')
                ->join('users', 'users.id', '=', '_recruitments.producer_id')
                ->select(
                    '_applicants.id as applicant_id',
                    '_recruitments.id as recruitment_id',
                    '_applicants.status as applicant_status',
                    '_recruitments.status as recruitment_status',
                    '_recruitments.*',
                    '_applicants.*',
                    'users.*'
                )
                ->where('_applicants.worker_id', $userData->id)
                ->where('_recruitments.status', '<>', 'draft')
                ->orderByDesc('_applicants.updated_at')
                ->skip($data['skip'])
                ->take($data['limit'])
                ->get();
        }
        else {
            $recruitments = Applicant::join('_recruitments', '_recruitments.id', '=', '_applicants.recruitment_id')
                ->join('users', 'users.id', '=', '_recruitments.producer_id')
                ->select(
                    '_applicants.id as applicant_id',
                    '_recruitments.id as recruitment_id',
                    '_applicants.status as applicant_status',
                    '_recruitments.status as recruitment_status',
                    '_recruitments.*',
                    '_applicants.*',
                    'users.*'
                )
                ->where('_applicants.worker_id', $userData->id)
                ->where('_recruitments.status', '<>', 'draft')
                ->where(function($query) use($conditions){
                    if($conditions['waiting']) $query->orWhere('_applicants.status', 'waiting');
                    if($conditions['approved']) $query->orWhere('_applicants.status', 'approved');
                    if($conditions['rejected']) $query->orWhere('_applicants.status', 'rejected');
                    if($conditions['abandoned']) $query->orWhere('_applicants.status', 'abandoned');
                    if($conditions['finished']) $query->orWhere('_applicants.status', 'finished');
                })
                ->where(function($query) use($conditions){
                    $query->where('title', 'like', '%'.$conditions['keyword'].'%')
                        ->orWhere('description', 'like', '%'.$conditions['keyword'].'%')
                        ->orWhere('notice', 'like', '%'.$conditions['keyword'].'%');
                })
                ->orderByDesc('_applicants.updated_at')
                ->skip($data['skip'])
                ->take($data['limit'])
                ->get();
        }

        return $this->sendResponse($recruitments, 'recruitments data');
    }

    public function getAll(Request $request): JsonResponse
    {
        $userData = auth('sanctum')->user();

        $recruitments = Applicant::join('_recruitments', '_recruitments.id', '=', '_applicants.recruitment_id')
            ->join('users', 'users.id', '=', '_recruitments.producer_id')
            ->select(
                '_applicants.id as applicant_id',
                '_recruitments.id as recruitment_id',
                '_applicants.status as applicant_status',
                '_recruitments.status as recruitment_status',
                '_recruitments.*',
                '_applicants.*',
                'users.*'
            )
            ->where('_applicants.worker_id', $userData->id)
            ->where('_recruitments.status', '<>', 'draft')
            ->orderByDesc('_applicants.updated_at')
            ->get();

        return $this->sendResponse($recruitments, 'recruitments data');
    }

}
