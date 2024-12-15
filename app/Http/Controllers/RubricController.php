<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\Redirect;


class RubricController extends Controller
{
    public function __construct()
    {
        $rubrics = Type::all();
        view()->share('rubrics', $rubrics);
    }
    public function create()
    {
        return view('rubrics.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:rubrics|string|max:255',
        ], [
            'name.unique' => 'Такое название рубрики существует!',
        ]);
        Type::create($validatedData);
        return redirect()->route('index');
    }
}
