<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $header = 'Резюме и вакансии';
        return view('page', compact('header'));
    }

    public function show($id = 1)
    {
        $data = [
            'surname' => 'Иванов',
            'staff' => 'Программист',
            'phone' => '55-55-55',
            'stage' => '4 года',
            'photo' => 'ava1.jpg',
        ];
        return view('resume', compact('data'));
    }
}
