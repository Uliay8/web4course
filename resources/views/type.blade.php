@extends('layout.general')

@section('line')
@endsection

@section('content')
    <div class="hover"></div>
    <div class="title">{{ $type->name }}</div>
    <div class="row--small grid between">
        <div class="content">
            <img src="{{ asset('images/elifant.png') }}">
            <p>{{ $type->description }}</p>
        </div>
        <ul class="menu">
            @foreach($types as $type)
                <li><a href="{{ route('type', $type->id) }}">{{ $type->name }}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="row shedule">
        <div class="row--small">
            <h2>Расписание</h2>
            <div class="drivers">

                @foreach($workshops as $ws)
                <div class="driver grid">
                    <div class="driver-left grid">
                        <div class="driver-photo">
                            <img src="{{ asset('images/' . $ws->image .'.png') }}">
                        </div>
                        <div class="driver-text">
                            <div class="driver-name">{{ $ws->name }} <br><br>{{ $ws->fio }}</div>
                            <div class="driver-desc">{{ $ws->description }}
                            </div>
                        </div>
                    </div>
                    <div class="driver-right">
                        @if(Config::get('user.is_registered'))
{{--                            если нет ключа, то места свободны
                                или если колво мест-занятые места не 0, то места есть
                                и если пользователь не мастер
                                и если юзер туда не записан--}}
                            @if((!array_key_exists($ws->id, $counts) || $ws->number_of_seats-$counts[$ws->id]!=0)
                                && !Config::get('user.is_master')
                                && !$included[$ws->id])
                                <form action="{{ route('confirm-ws', $ws->id) }}" style=" width: 100%;">
                                    <button class="driver-btn">записаться</button>
                                </form>
                            @else
                                <button class="driver-btn" disabled >записаться</button>
                            @endif
                        @endif

                        @if($included[$ws->id])
                                <div class="driver-time" style="color: red">Вы уже записаны на этот мастер класс!</div>
                        @endif
                        <div class="driver-time">Дата: {{ Str::substr($ws->date, 8, 2) }}.{{ Str::substr($ws->date, 5, 2) }}.{{ Str::substr($ws->date, 2, 2) }}
                            <br>Слот: {{ $ws->slot }} часов</div>
                        <div class="driver-time">Стоимость: {{ $ws->cost }} руб.</div>
                        <div class="driver-time">Количество свободных мест: {{ array_key_exists($ws->id, $counts)?$ws->number_of_seats-$counts[$ws->id]:$ws->number_of_seats }}</div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection

@section('line-two')
@endsection

{{--<section>--}}
{{--    <div class="section_main">--}}
{{--        <div class="row">--}}
{{--            <section class="eight columns">--}}

{{--                <h3>{{ $rubrika->name }}</h3>--}}
{{--                @foreach ($statyas as $statya)--}}
{{--                    <article class="blog_post">--}}
{{--                        <div class="three columns">--}}
{{--                            <a href="{{ route('statya', $statya->id) }}" class="th">--}}
{{--                                <img src="{{ asset('storage/images/'.$statya->image) }}" alt="{{ $statya->title }}" />--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                        <div class="nine columns">--}}
{{--                            <a href="{{ route('statya', $statya->id) }}"><h4>{{ $statya->title }}</h4></a>--}}
{{--                            <p>{{ Str::limit($statya->lid, 100) }}</p>--}}
{{--                            @if (Config::get('user.is_admin'))--}}
{{--                                <form action="{{ route('statya.destroy', $statya->id) }}" method="POST" style="display: inline;">--}}
{{--                                    @csrf--}}
{{--                                    @method('DELETE')--}}
{{--                                    <button type="submit">Удалить</button>--}}
{{--                                </form>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </article>--}}
{{--                @endforeach--}}
{{--            </section>--}}
{{--            @if (Config::get('user.is_admin'))--}}
{{--                <section class="four columns">--}}
{{--                    <H3>  &nbsp;   </H3>--}}
{{--                    <div class="panel">--}}
{{--                        <h3>Админ-панель</h3>--}}
{{--                        <ul class="accordion">--}}
{{--                            <li class="active">--}}
{{--                                <div class="title">--}}
{{--                                    <a href="{{ route('add.create') }}"><h5>Добавить статью</h5></a>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                            <li class="active">--}}
{{--                                <div class="title">--}}
{{--                                    <a href="{{ route('rubrics.create') }}"><h5>Добавить рубрику</h5></a>--}}
{{--                                </div>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </section>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
