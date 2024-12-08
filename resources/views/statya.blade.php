@extends('layout.general')

@section('header')
    <div class="row">
        <a href="{{ route('rubrika', $statya->rubric_id) }}" style="text-decoration: none">
            <h4>{{ $rubrika->name }}</h4>
            {{--                {{ $statya->rubrics }}--}}
        </a>
        <article>
            <div class="twelve columns">
                <h1>{{ $statya->title }}</h1>
                <p class="excerpt">{{ $statya->lid }}</p>
            </div>
        </article>
    </div>
@endsection

@section('content')
    <section class="section_light">
        <div class="row">
            <p> <img src="{{ asset('storage/images/'.$statya->image) }}"
                     alt="{{ $statya->title }}" width="400" align="left" hspace="30">
                {{ $statya->content }}</p>
        </div>
    </section>
@endsection
