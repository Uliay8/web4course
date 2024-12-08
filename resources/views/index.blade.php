@extends('layout.general')

@section('header')
    <div class="row">
        <a href="{{ route('index') }}" style="text-decoration: none"><h1>Новости науки</h1></a>
    </div>
@endsection

@section('content')
    <div class="section_main">
        <div class="row">
            <section class="eight columns">
                @foreach($statyas as $statya)
                    <article class="blog_post">
                        <div class="three columns">
                            <a href="{{ route('statya', $statya->id) }}" class="th">
                                <img src="{{ asset('storage/images/' . $statya->image) }}" alt="{{ $statya->title }}" />
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
        </div>
    </div>
@endsection
