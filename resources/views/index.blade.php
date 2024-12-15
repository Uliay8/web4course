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
@endsection

@section('line-two')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
@endsection


{{--<div class="section_main">--}}
{{--    <div class="row">--}}
{{--        <section class="eight columns">--}}
{{--            @foreach($statyas as $statya)--}}
{{--                <article class="blog_post">--}}
{{--                    <div class="three columns">--}}
{{--                        <a href="{{ route('statya', $statya->id) }}" class="th">--}}
{{--                            <img src="{{ asset('storage/images/' . $statya->image) }}" alt="{{ $statya->title }}" />--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                    <div class="nine columns">--}}
{{--                        <a href="{{ route('statya', $statya->id) }}"><h4>{{ $statya->title }}</h4></a>--}}
{{--                        <p>{{ Str::limit($statya->lid, 100) }}</p>--}}
{{--                        @if (Config::get('user.is_admin'))--}}
{{--                            <form action="{{ route('statya.destroy', $statya->id) }}" method="POST" style="display: inline;">--}}
{{--                                @csrf--}}
{{--                                @method('DELETE')--}}
{{--                                <button type="submit">Удалить</button>--}}
{{--                            </form>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </article>--}}
{{--            @endforeach--}}
{{--        </section>--}}
{{--    </div>--}}
{{--</div>--}}
