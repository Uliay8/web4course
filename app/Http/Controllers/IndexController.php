<?php

namespace App\Http\Controllers;

use App\Models\Rubric;
use App\Models\Statya;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class IndexController extends Controller
{
    public function __construct()
    {
        $rubrics = Rubric::all();
        view()->share('rubrics', $rubrics);
    }
    public function index()
    {
        if (Config::get('user.is_registered')) {
//            dump(Config::get('user.is_admin'));
            $statyas = Statya::all();
            return view('index', compact('statyas'));
        } else {
            return view('auth.login');
        }
    }
    public function rubrika($rubric_id)
    {
        $statyas = Statya::where('rubric_id', $rubric_id)->get();
        $rubrika = Rubric::find($rubric_id);
        return view('rubrika', compact('statyas', 'rubrika'));
    }
    public function statya($id)
    {
        $statya = Statya::find($id);
        $rubrika = Rubric::find($statya->rubric_id);
        return view('statya', compact('statya', 'rubrika'));
    }
    public function checkUser(Request $request)
    {
        $user = User::where('email', $request->get('email'))->first();
        if (!$user) {
            dd("the user does not exist");
        }
        if ($user->password != $request->get('password')) {
            dd("the password is incorrect");
        }
        config(['user.is_registered' => true]);
        config(['user.is_admin' => $user->admin]);
        config(['user.name' => $user->name]);
        $fp = fopen(base_path() .'/config/user.php' , 'w');
        fwrite($fp, '<?php return ' . var_export(config('user'), true) . ';');
        fclose($fp);
        return redirect()->route('index');
    }
    public function logoutUser(Request $request){
        config(['user.is_registered' => false]);
        config(['user.is_admin' => false]);
        config(['user.name' => ""]);
        $fp = fopen(base_path() .'/config/user.php' , 'w');
        fwrite($fp, '<?php return ' . var_export(config('user'), true) . ';');
        fclose($fp);
        return redirect()->route('index');
    }

    public function destroy($id)
    {
//        if (!Auth::check() || !Auth::user()->is_admin) {
//            return redirect()->route('index');
//        }
        $statya = Statya::findOrFail($id);
        $statya->delete();
        return redirect()->route('index');

    }

    public function create()
    {
//        if (!Auth::check() || !Auth::user()->is_admin) {
//            return redirect()->route('index');
//        }
        return view('add');
    }

    public function store(Request $request)
    {
//        if (!Auth::check() || !Auth::user()->is_admin) {
//            return redirect()->route('index');
//        }
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'lid' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,gif,jpg|max:2048',
            'rubric_id' => 'required',
        ]);

        $imagePath = "";
        if ($request->hasFile('image')){
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = basename($imagePath);
        }

        Statya::create($validatedData);

        return redirect()->route('index');
    }
}
