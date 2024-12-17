<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $types = Type::all();
        view()->share('types', $types);
    }

    public function logoutUser(Request $request){
        config(['user.is_registered' => false]);
        config(['user.is_master' => false]);
        config(['user.fio' => ""]);
        config(['user.user_id'=>null]);
        $fp = fopen(base_path() .'/config/user.php' , 'w');
        fwrite($fp, '<?php return ' . var_export(config('user'), true) . ';');
        fclose($fp);
        return redirect()->route('index');
    }
    public function toLoginUser()
    {
        return view('auth.login');
    }
    public function toRegisterUser()
    {
        return view('auth.register');
    }

    public function checkUser(Request $request)
    {
        $user = User::where('email', $request->get('email'))->first();
        if (!$user) {
            dd("the user does not exist");
        }
        if ($user->password != $request->get('password')) {
            if(!Hash::check($request->get('password'), $user->password)) {
                dd("the password is incorrect");
            }
        }
        config(['user.is_registered' => true]);
        config(['user.is_master' => $user->is_master]);
        config(['user.fio' => $user->fio]);
        config(['user.user_id'=>$user->id]);
        $fp = fopen(base_path() .'/config/user.php' , 'w');
        fwrite($fp, '<?php return ' . var_export(config('user'), true) . ';');
        fclose($fp);
        return redirect()->route('index');
    }

    public function registerUser(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|unique:users|string|max:255',
            'password' => 'required|string|max:255',
            'fio' => 'required|regex:/^[А-Я][а-я]+\s[А-Я][а-я]+\s[А-Я][а-я]+$/u',
            'number' => 'required|regex:/^8\d{10}$/',
            'birthday' => 'required'
        ], [
            'number.regex' => 'Телефон должен быть из 11 цифр и начинаться с 8!',
            'fio.regex' => 'Напишите ФИО кириллицей!',
            'email.unique' => 'Напишите уникальный адрес!!',
        ]);

        $user = new User();
        $user->fio = $validatedData['fio'];
        $user->email = $validatedData['email'];
        $user->number = $validatedData['number'];
        $user->password = $validatedData['password'];
        $user->birthday = $validatedData['birthday'];
        $user->is_master = false;
        $user->save();

        $user = User::where('email', $request->get('email'))->first();
        config(['user.is_registered' => true]);
        config(['user.is_admin' => $user->admin]);
        config(['user.fio' => $user->fio]);
        config(['user.user_id'=>$user->id]);
        $fp = fopen(base_path() .'/config/user.php' , 'w');
        fwrite($fp, '<?php return ' . var_export(config('user'), true) . ';');
        fclose($fp);
        return redirect()->route('index');
    }
}
