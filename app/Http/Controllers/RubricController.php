<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubric;
use Illuminate\Support\Facades\Redirect;


class RubricController extends Controller
{
    public function __construct()
    {
        $rubrics = Rubric::all();
        view()->share('rubrics', $rubrics);
    }
    public function create()
    {
        return view('rubrics.create');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:rubrics|max:255',
        ]);
        $rubric = Rubric::create([
            'name' => $validatedData['name'],
        ]);
        return redirect()->route('index');
    }
}
