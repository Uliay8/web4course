@extends('layout.general')

@section('header')
    <div class="row">
        <a href="{{ route('index') }}" style="text-decoration: none"><h1>Новости науки</h1></a>
    </div>
@endsection

@section('content')
    <section>
        <div class="section_main">
            <div class="row">
                <section class="eight columns">

                    <h3>{{ $rubrika->name }}</h3>
                    @foreach ($statyas as $statya)
                        <article class="blog_post">
                            <div class="three columns">
                                <a href="{{ route('statya', $statya->id) }}" class="th">
                                    <img src="{{ asset('storage/images/'.$statya->image) }}" alt="{{ $statya->title }}" />
                                </a>
                            </div>
                            <div class="nine columns">
                                <a href="{{ route('statya', $statya->id) }}"><h4>{{ $statya->title }}</h4></a>
                                <p>{{ Str::limit($statya->lid, 100) }}</p>
                                @if (Config::get('user.is_admin'))
                                    <form action="{{ route('statya.destroy', $statya->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Удалить</button>
                                    </form>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </section>
                @if (Config::get('user.is_admin'))
                    <section class="four columns">
                        <H3>  &nbsp;   </H3>
                        <div class="panel">
                            <h3>Админ-панель</h3>
                            <ul class="accordion">
                                <li class="active">
                                    <div class="title">
                                   <a href="{{ route('add.create') }}"><h5>Добавить статью</h5></a>
                                    </div>
                                </li>
                                <li class="active">
                                    <div class="title">
                                        <a href="{{ route('rubrics.create') }}"><h5>Добавить рубрику</h5></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </section>
@endsection
