@extends('layout.general')

@section('content')
    <div class="leftcol"><!--**************Основное содержание страницы************-->
        <h1>Фамилии и стаж людей с профессией программист</h1>

        <table>
            <tr>
                <th>Фамилия</th>
                <th>Стаж</th>
                <th>Профессия</th>
            </tr>
            @foreach($persons as $person)
                <tr>
                    <td>{{ $person->fio }}</td>
                    <td>{{ $person->stage }}</td>
                    <td>{{ $person->staff }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
