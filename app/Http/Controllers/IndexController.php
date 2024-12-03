<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Firm;
use App\Models\Person;
use App\Models\Vacancy;

class IndexController extends Controller
{
//    public function index()
//    {
//        $header = 'Резюме и вакансии';
//        return view('page', compact('header'));
//    }

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

    public function personCreate()
    {
        $staffs = Staff::pluck('staff');
        return view('add-content', compact('staffs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fio' => ['required', 'regex:/^[А-Я][а-я]+\s[А-Я][а-я]+\s[А-Я][а-я]+$/u'],
            'stage' => ['required', 'numeric', 'min:0'],
            'phone' => ['required', 'regex:/^8\d{10}$/'],
            'staff' => ['required', 'string', 'exists:Staff,staff'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png'],
        ], [
            'fio.regex' => 'Напишите ФИО кириллицей!',
            'stage.min' => 'Стаж введён неверно!',
            'phone.regex' => 'Телефон должен быть из 11 цифр и начинаться с 8!',
            'staff.exists' => 'Должность не существует!',
            'image.mimes' => 'Изображение должно быть в формате jpg, jpeg или png!',
            'image.image' => 'Загруженный файл должен быть изображением!',
        ]);

        $staffEntry = Staff::where('staff', $validated['staff'])->first();
        $imagePath = "";
         //E:/Git/web4course/
        if ($request->hasFile('image')){
            $imagePath = $request->file('image')->store('images', 'public');
        }
//        dd($request->file('image')->store('images', 'public'));
        $person = new Person();
        $this->savePersonTodb($validated, $person, $staffEntry, $imagePath);

        return redirect()->route('person.index')->with('success', 'Резюме добавлено.');
    }

    public function index()
    {
        $persons = Person::all();
        return view('person', ['persons' => $persons]);
    }

    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        return redirect()->route('person.index')->with('success', 'Резюме удалено.');
    }
    public function edit($id)
    {
        $person = Person::findOrFail($id);
        $staffs = Staff::pluck('staff');
        return view('edit-content', compact('person', 'staffs'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fio' => ['required', 'regex:/^[А-Я][а-я]+\s[А-Я][а-я]+\s[А-Я][а-я]+$/u'],
            'stage' => ['required', 'numeric', 'min:0'],
            'phone' => ['required', 'regex:/^8\d{10}$/'],
            'staff' => ['required', 'string', 'exists:Staff,staff'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
        ], [
            'fio.regex' => 'Напишите ФИО кириллицей!',
            'stage.min' => 'Стаж введён неверно!',
            'phone.regex' => 'Телефон должен быть из 11 цифр и начинаться с 8!',
            'staff.exists' => 'Должность не существует!',
            'image.mimes' => 'Изображение должно быть в формате jpg, jpeg или png!',
            'image.image' => 'Загруженный файл должен быть изображением!',
        ]);

        $staffEntry = Staff::where('staff', $validated['staff'])->first();
        $person = Person::findOrFail($id);
        $imagePath = "";
        if ($request->hasFile('image')){
            $imagePath = $request->file('image')->store('public/images');
        } else {
            $imagePath = $person->image;
        }


        $this->savePersonTodb($validated, $person, $staffEntry, $imagePath);

        return redirect()->route('person.index')->with('success', 'Резюме обновлено.');
    }

    /**
     * @param array $validated
     * @param Person $person
     * @param $staffEntry
     * @param false|string $imagePath
     * @return void
     */
    public function savePersonTodb(array $validated, Person $person, $staffEntry, false|string $imagePath): void
    {
        $person->fio = $validated['fio'];
        $person->stage = $validated['stage'];
        $person->phone = $validated['phone'];
        $person->staff = $staffEntry->id;
        $person->image = basename($imagePath);
        $person->save();
    }
}
