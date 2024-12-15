<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Type;
use App\Models\Workshop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function __construct()
    {
        $types = Type::all();
        view()->share('types', $types);
    }
    public function index()
    {
        if (Config::get('user.is_master')) {
//            dump(Config::get('user.is_admin'));
//            $statyas = Workshop::all();compact('statyas')
            return $this->cabinet();
        }
        // admin - lk ? usser - mainpage
        return view('index');
    }
    public function type($type_id)
    {
        $workshops = Workshop::join('users', 'workshops.master_id', '=', 'users.id')
            ->join('hours', 'workshops.time_id', '=', 'hours.id')
            ->where('type_id', $type_id)
            ->select('workshops.id', 'image', 'name', 'fio', 'description', 'date', 'slot', 'cost', 'number_of_seats')
            ->get();
        $parts = Participant::join('workshops', 'participants.workshop_id', '=', 'workshops.id')
            ->where('type_id', $type_id)
            ->select('workshop_id')
            ->distinct()
            ->get(); // workshop_id all
        $counts = array();
        $included = array();
        foreach ($parts as $part) {
            $count = Participant::where('workshop_id', $part->workshop_id)
                ->groupBy('workshop_id')
                ->count();
            $counts[$part->workshop_id] = $count;
        }
        foreach ($workshops as $ws) {
            $isIncluded = Participant::where('workshop_id', $ws->id)
                ->where('user_id', Config::get('user.user_id'))
                ->get();
            if(count($isIncluded)==1) {
                $included[$ws->id] = true;
            } else {
                $included[$ws->id] = false;
            }
        }
//        dd($included);
        $type = Type::find($type_id);
        return view('type', compact('workshops', 'type', 'counts', 'included'));
    }
    public function cabinet(){
        $master_id = Config::get('user.user_id');
        $master = User::where('id', $master_id)->first();
        $workshops = Workshop::join('users', 'workshops.master_id', '=', 'users.id')
            ->join('hours', 'workshops.time_id', '=', 'hours.id')
            ->where('workshops.master_id', $master_id)
            ->select('workshops.id', 'name', 'date', 'slot')
            ->get();
        $participants = array();
        foreach ($workshops as $ws) {
            $part = Participant::join('users', 'participants.user_id', '=', 'users.id')
                ->where('workshop_id', $ws->id)
                ->select('participants.workshop_id', 'fio', 'email', 'number', 'birthday')
                ->get();
            $participants[$ws->id] = $part;
        }
//        dd($participants);
        return view('cabinet', compact('master', 'workshops', 'participants'));
    }

    public function toConfirm($ws_id){
//        ФИО пользователя, вид творчества, ФИО мастера, дата, время, кнопки подтверждения и отмены.
        $userFio = Config::get('user.fio');
        $ws = Workshop::where('workshops.id', $ws_id)
            ->join('users', 'workshops.master_id', '=', 'users.id')
            ->join('hours', 'workshops.time_id', '=', 'hours.id')
            ->join('types', 'workshops.type_id', '=', 'types.id')
            ->select('workshops.id', 'workshops.name', 'users.fio', 'workshops.date', 'hours.slot', 'workshops.type_id')
            ->get();
        $ws = $ws[0];
//        dd($ws);
        return view('confirm', compact('ws', 'userFio'));
    }
    public function toCancelWs($type_id){
        return redirect()->route('type', $type_id)->with('success', 'Отмена успешна');
    }
    public function storePart($ws_id){
        $part = new Participant();
        $part->user_id = Config::get('user.user_id');;
        $part->workshop_id = $ws_id;
        $part->save();
        $type_id = Workshop::where('id', $ws_id)
            ->select('type_id')
            ->get();
        $type_id = $type_id[0]->type_id;
//        dd($type_id);
        return redirect()->route('type', $type_id)->with('success', 'Запись добавлена');
    }


    public function statya($id)
    {
        $statya = Workshop::find($id);
        $rubrika = Type::find($statya->rubric_id);
        return view('statya', compact('statya', 'rubrika'));
    }


    public function destroy($id)
    {
        $statya = Workshop::findOrFail($id);
        $statya->delete();
        return redirect()->route('index');

    }
    public function create()
    {
        return view('add');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:statya|string|max:255',
            'lid' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,gif,jpg|max:2048',
            'rubric_id' => 'required',
        ], [
            'title.unique' => 'Напишите уникальное имя статьи!',
        ]);

        $imagePath = "";
        if ($request->hasFile('image')){
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = basename($imagePath);
        }

        Workshop::create($validatedData);
        return redirect()->route('index');
    }
}
