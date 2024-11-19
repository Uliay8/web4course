<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Firm;
use App\Models\Person;
use App\Models\Vacancy;

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

    public function showPersonsByStageFromTo($from = 5, $to = 15)
    {
        $persons = Person::whereBetween('stage', [$from, $to])->get(['fio', 'stage']);
        return view('stage', ['persons' => $persons]);
    }

    public function showPersonsAndStageByStaff($staff = 'Программист')
    {
        $persons = Person::join('Staff', 'Person.staff', '=', 'Staff.id')
        ->select('Person.fio', 'Person.stage', 'Staff.staff')
        ->where('Staff.staff', '=', $staff)
        ->get();

        return view('staff', ['persons' => $persons]);
    }

    public function showCountResumes()
    {
        $countResumes = Person::count();
        return view('resumes', ['countResumes'=>$countResumes]);
    }

    public function showDistinctProfessions()
    {
        $persons = Person::join('Staff', 'Person.staff', '=', 'Staff.id')
            ->select('Staff.staff')
            ->distinct()
            ->get();
        return view('professions', ['persons' => $persons]);
    }

}
