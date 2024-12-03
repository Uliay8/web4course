@extends('layout.general')

@section('content')
    <div class="leftcol"><!--**************Основное содержание страницы************-->
        <h1>Добавить резюме</h1>
        <form method="POST" action="{{route('person.store')}}" enctype="multipart/form-data">
            @csrf
            <label for="fio">ФИО:</label>
            <input type="text" id="fio" name="fio" value="{{ old('fio') }}" required>
            @error('fio')
            <p style="color: red;">{{ $message }}</p>
            @enderror
            <br><br>

            <label for="stage">Стаж:</label>
            <input type="number" id="stage" name="stage" value="{{ old('stage') }}" required>
            @error('stage')
            <p style="color: red;">{{ $message }}</p>
            @enderror
            <br><br>

            <label for="phone">Телефон:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
            @error('phone')
            <p style="color: red;">{{ $message }}</p>
            @enderror
            <br><br>

            <label for="staff">Должность:</label>
            <select id="staff" name="staff" required>
                @foreach($staffs as $staff)
                    <option value="{{ $staff }}">{{ $staff }}</option>
                @endforeach
            </select>
            @error('staff')
            <p style="color: red;">{{ $message }}</p>
            @enderror
            <br><br>

            <label for="image">Фото:</label>
            <input type="file" id="image" name="image" accept="image/*" >
            @error('image')
            <p style="color: red;">{{ $message }}</p>
            @enderror
            <br><br>

            <button type="submit">Добавить</button>
        </form>
    </div>
@endsection
