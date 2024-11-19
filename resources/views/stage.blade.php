@extends('layout.general')

@section('content')
    <div class="leftcol"><!--**************Основное содержание страницы************-->
        <h1>Фамилии персон, имеющих стаж от 5 до 15 лет</h1>

            <table>
                <tr>
                    <th>Фамилия</th>
                    <th>Стаж</th>
                </tr>
                @foreach($persons as $person)
                    <tr>
                        <td>{{ $person->fio }}</td>
                        <td>{{ $person->stage }}</td>
                    </tr>
                @endforeach
            </table>
    </div>
@endsection
