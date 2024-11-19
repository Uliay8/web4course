@extends('layout.general')

@section('content')
    <div class="leftcol"><!--**************Основное содержание страницы************-->
        <h1>Профессии, представители которых имеются в резюме</h1>
        <table>
            <tr>
                <th>Профессия</th>
            </tr>
            @foreach($persons as $person)
                <tr>
                    <td>{{ $person->staff }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
