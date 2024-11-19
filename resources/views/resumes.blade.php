@extends('layout.general')

@section('content')
    <div class="leftcol"><!--**************Основное содержание страницы************-->
        <h1>Общее количество резюме в базе</h1>
        <p class="second">Всего: {{ $countResumes }}</p>
    </div>
@endsection
