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

    public function show()
    {
        $data = [
            'surname' => 'Иванов',
            'profession' => 'Программист',
            'phone' => '55-55-55',
            'experience' => '4 года',
            'avatar' => 'ava1.jpg',
        ];
        return view('resume', compact('data'));
    }
}
