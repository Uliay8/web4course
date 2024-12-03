@extends('layout.general')

@section('content')
    <div class="leftcol"><!--**************Основное содержание страницы************-->
        <h1>Список всех резюме</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table>
            <thead>
            <tr>
                <th>id</th>
                <th>ФИО</th>
                <th>Стаж</th>
                <th>Телефон</th>
                <th>Должность</th>
                <th>Фото</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($persons as $person)
                <tr>
                    <td>{{ $person->id }}</td>
                    <td>{{ $person->fio }}</td>
                    <td>{{ $person->stage }}</td>
                    <td>{{ $person->phone }}</td>
                    <td>{{ $person->staff }}</td>
                    <td>
                        @if($person->image)
                            <img src="{{ asset('storage/images/' . $person->image) }}" alt="Фото" style="width:100px; height:100px;">
                        @else
                            Нет изображения
                        @endif
                    </td>
                    <td>
                        <button type="submit">
                            <a href="{{ route('person.edit', $person->id) }}" style="text-decoration: none; color: black">
                                Редактировать
                            </a>
                        </button> |
                        <form action="{{ route('person.destroy', $person->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Вы уверены?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
