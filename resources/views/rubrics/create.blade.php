@extends('layout.general')

@section('content')
    <div class="section_main">
        <div class="row">
            <section class="twelve columns">
                <h2>Добавить Рубрику</h2>
                <form method="POST" action="{{ route('rubrics.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Название рубрики:</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <button type="submit">Создать</button>
                </form>
            </section>
        </div>
    </div>
@endsection
