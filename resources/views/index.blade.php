@extends('layout.general')

@section('line')
@endsection

@section('content')
    <div class="hover"></div>
    <div class="title">Главная страница</div>
    <div class="row--small grid between">
        <div class="content">
            <img src="{{ asset('images/elifant.png') }}">
            <p>Ознакомьтесь с нашими мастер-классами!</p>
        </div>
        <ul class="menu">
            @foreach($types as $type)
                <li><a href="{{ route('type', $type->id) }}">{{ $type->name }}</a></li>
            @endforeach
        </ul>
    </div>
    @if(Config::get('user.is_registered')&&!Config::get('user.is_master'))
        <div class="row shedule">
            <div class="row--small">
                <h2>Куда я записался</h2>
                <div class="drivers">
                    @foreach($usersWorkshops as $ws)
                        <div class="driver grid">
                            <div class="driver-left grid">
                                <div class="driver-text">
                                    <div class="driver-name">{{ $ws->name }} <br><br>ФИО мастера: {{ $ws->fio }}</div>
                                </div>
                            </div>
                            <div class="driver-right">
                                <div class="driver-time">Дата: {{ Str::substr($ws->date, 8, 2) }}.{{ Str::substr($ws->date, 5, 2) }}.{{ Str::substr($ws->date, 2, 2) }}
                                    <br>Слот: {{ $ws->slot }} часов</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection

@section('line-two')
    @if(!Config::get('user.is_registered')||Config::get('user.is_master'))
        <div class="row row--nogutter top-line">
            <div class="line"></div>
        </div>
    @endif
@endsection

