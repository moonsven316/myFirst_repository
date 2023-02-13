<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Machine;
use App\Models\MngMode;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/activate';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', [
            'except' => 'logout',
        ]);
    }

    public function index($role = 'worker')
    {
        return view('auth.register')->with(['role' => $role]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:30|confirmed',
                'password_confirmation' => 'required|same:password',
                'family_name' => 'required', 
            ],
            [
                'email.required' => 'メールフィールドは必須です。',
                'email.unique' => 'メールはすでに取られています。',
                'email.email' => 'メールは有効なメールアドレスである必要があります。',
                'email.max' => '電子メールは255文字を超えてはなりません。',

                'password.required' => 'パスワードフィールドは必須です。',
                'password.min' => 'パスワードは6文字以上である必要があります。',
                'password.max' => 'パスワードは30文字以内にする必要があります。',
                'password.confirmed' => 'パスワードの確認が一致しません。',

                'password_confirmation.required' => 'パスワード確認フィールドは必須です。',
                'password_confirmation.same' => 'パスワードの確認とパスワードは一致している必要があります。',

                'family_name.required' => '名前フィールドは必須です。',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        
        Auth::login($user);

        return redirect()->route('welcome');
    }

    protected function create(array $data)
    {
        
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'user';
        $user = User::create($data);

        $user->save();

        for ($i=0; $i < 5; $i++) { 
            $machine = new Machine;
            $machine->user_id = $user->id;
            $machine->save();
        }

        return $user;
    }

}
