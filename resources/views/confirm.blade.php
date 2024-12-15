@extends('layout.general')

@section('line')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
@endsection

@section('content')
    <div class="row--small">
        <form method="POST" action="{{ route('storePart', $ws->id) }}">
            @csrf
            <h2>Форма подтверждения</h2><br>
            <div class="form-group">
                <label>ФИО: {{ $userFio }}</label>
            </div>
            <div class="form-group">
                <label>Название мастер класса: {{ $ws->name }}</label>
            </div>
            <div class="form-group">
                <label>ФИО мастера: {{ $ws->fio }}</label>
            </div>
            <div class="form-group">
                <label>Дата: {{ $ws->date }}</label>
            </div>
            <div class="form-group">
                <label>Слот: {{ $ws->slot }}</label>
            </div>
            <div class="form-group">
                <button class="btn">Подтвердить</button>
            </div>
            <a href="{{ route('toCancelWs', $ws->type_id) }}" style="text-decoration: none">
                <h4>Отмена</h4>
            </a>
        </form>

    </div>
@endsection

@section('line-two')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
@endsection
