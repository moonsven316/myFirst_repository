<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use App\Models\ExhibitSettings;
use App\Models\Brands;
use App\Models\User;
use App\Models\Item;
use App\Models\Machine;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MypageController extends Controller
{  
	public function check_pwd(Request $request)
	{
		$user_data = json_decode($request['postData']);
		$user = User::find(Auth::user()->id);
		$password = $user_data->password;

		if (!Hash::check($password, $user->password)) {
			return true;
		}
	}

	public function change_pwd(Request $request)
	{
		$newPwd = $request['postData'];
		$user = User::find(Auth::user()->id);
		$user->forceFill([
			'password' => Hash::make($newPwd),
		])->save();
	}

	public function change_info(Request $request)
	{
		$user_info = json_decode($request['postData']);
		$user = User::find(Auth::user()->id);
		$user->access_key = $user_info->access;
		$user->secret_key = $user_info->secret;
		$user->save();
	}

	public function change_line(Request $request)
	{
		$user_info = json_decode($request['postData']);
		$user = User::find(Auth::user()->id);
		$user->access_token = $user_info->access;
		$user->save();
	}

	public function delete_account(Request $request)
	{
		$id = $request->id;
		User::find($id)->delete();
		Machine::where('user_id',$id)->delete();
		Product::where('user_id',$id)->delete();
	}

	public function permit_account(Request $request)
	{
		$id = $request['id'];
		$user = User::find($id);
		$user->is_permitted = $request['isPermitted'];
		$user->save();
	}

	public function save_machine(Request $request)
	{
		$req = json_decode($request['exData']);
		// dd($req);
		$machine = Machine::find($req->machine_id);
		if ($machine == null) {
			$machine = new Machine;
		}

		$machine->user_id =Auth::id();
		$machine->access_key = $req->access_key;
		$machine->secret_key = $req->secret_key;
		$machine->category = $req->category;
		$machine->down = $req->down;
		$machine->web_hook = $req->web_hook;
		$machine->file_name = $req->file_name;
		$machine->len = $req->len;
		$machine->save();
	}

	public function register_product(Request $request)
	{
		$user = Auth::user();
		// $machines = $user->machines;
		$machines = Machine::where('user_id', $user->id)->paginate(1);
		return view('mypage.register_product', ['machines' => $machines]);
	}

	public function users_profile(Request $request)
	{

		// $id = $request['id'];
	
		$user = User::find(Auth::id());
		return view('mypage.users_profile', ['user' => $user]);
	}

	public function admin_page(Request $request)
	{
 
		$machines = DB::table('machines')
		            ->join('users', 'machines.user_id', '=', 'users.id')
		            ->select('machines.*', 'users.email', 'users.is_permitted', 'users.role')
		            ->get()
		            ->groupBy('user_id');
		// $machines = $machine->groupBy('user_id');
		return view('mypage.admin_page', ['machines' => $machines]);
		 // return $machines;
	}

}
