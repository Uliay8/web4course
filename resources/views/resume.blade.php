@extends('general')

@section('content')
<div class="leftcol"><!--**************Основное содержание страницы************-->


    <div class="pinline1">
        <img class="pic" src="{{ asset('/images/ava1.jpg') }}">
    </div>

    <p class="pinline second">
        Иванов Иван

        <br>
        Телефон:
        111111

    </p>

    <p  class="pinline third">
        Программист
        <br>

        Стаж:
        10 лет

    </p>
</div>
@endsection
