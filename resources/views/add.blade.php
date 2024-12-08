@extends('layout.general')

@section('content')
    <div class="section_main">
        <div class="row">
            <section class="twelve columns">
                <h2>Добавить статью</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)

                                @if ($error == "The title field is required.")
                                    <li>Поле "Заголовок" обязательно для заполнения.</li>
                                @elseif ($error == "The lid field is required.")
                                    <li>Поле "Лид" обязательно для заполнения.</li>
                                @elseif ($error == "The content field is required.")
                                    <li>Поле "Контент" обязательно для заполнения.</li>
                                @elseif (strpos($error, 'image') !== false )
                                    @if($error == "The image field must be an image.")
                                        <li>Загруженный файл должен быть изображением.</li>
                                    @elseif($error == "The image field must be a file of type: jpeg, png, gif, jpg.")
                                        <li>Допустимые форматы изображений: jpeg, png, jpg, gif.</li>
                                    @elseif($error == "The image may not be greater than 2048 kilobytes.")
                                        <li>Размер изображения не должен превышать 2 МБ.</li>
                                    @else
                                        <li>{{$error}}</li>
                                    @endif
                                @elseif ($error == "The rubrics field is required.")
                                    <li>Поле "Рубрика" обязательно для заполнения.</li>
                                @else
                                    <li>{{ $error }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('add.store') }}" enctype="multipart/form-data" class="add-article-form">
                    @csrf
                    <div class="form-group">
                        <label for="title">Заголовок:</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="lid">Лид:</label>
                        <textarea name="lid">{{ old('lid') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="content">Контент:</label>
                        <textarea name="content">{{ old('content') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="image">Изображение:</label>
                        <input type="file" name="image" id="image">
                    </div>

                    <div class="form-group">
                        <label for="rubric_id">Рубрика:</label>
                        <select name="rubric_id" id="rubric_id">
                            @foreach($rubrics as $rubric)
                                <option value="{{ $rubric->id }}">{{ $rubric->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="button">Сохранить</button>
                </form>

            </section>
        </div>
    </div>
@endsection
