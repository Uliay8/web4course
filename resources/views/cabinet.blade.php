@extends('layout.general')

@section('line')
@endsection

@section('line-two')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
@endsection

@section('content')
    <div class="hover"></div>
    <div class="title"></div>
    <div class="row--small grid between">
        <div class="content driver-page">
            <div class="driver-page-photo">
                <img src="{{ asset('images/driver-page.png') }}">
            </div>
            <div class="driver-page-name">{{ $master->fio }}</div>
            <div class="driver-page-text">
                <div class="driver-page-my">Мои мастер-классы</div>
                <table class="driver-page-table">
                    <tbody>
                    @foreach($workshops as $ws)
                        <tr>
                            <td>{{ Str::substr($ws->date, 8, 2) }}.{{ Str::substr($ws->date, 5, 2) }}.{{ Str::substr($ws->date, 2, 2) }}
                                <br>{{$ws->slot}}</td>
                            <td>
                                <b>{{ $ws->name }}</b>
                                @php $i = 1;
                                @endphp
                                @if(!$participants[$ws->id]->isEmpty())
                                    @foreach($participants[$ws->id] as $pt)
                                        <p>
                                          {{$i}}.   {{$pt->fio}} ({{$pt->birthday}})<br>
                                            email: {{$pt->email}} <br>
                                            tel: {{$pt->number}}
                                        </p>
                                        @php $i++;
                                        @endphp
                                    @endforeach
                                @endif
                            </td>
                        </tr>
{{--                        <li><a href="{{ route('type', $type->id) }}">{{ $type->name }}</a></li>for all participants--}}
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="driver-page-btn-wrapper">
                <div class="driver-page-btn btn">
                    Добавить мастер-класс
                </div>
            </div>
        </div>
        <ul class="menu">
            @foreach($types as $type)
                <li><a href="{{ route('type', $type->id) }}">{{ $type->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection
