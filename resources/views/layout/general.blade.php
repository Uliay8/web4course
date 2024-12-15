<!DOCTYPE html>
<html lang="en">
<head>
    <title>Main Page</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}">
</head>

<body class="dp">
<div class="header">
    <div class="row grid middle between">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}">
        </div>
        <div class="title">
            <a href="{{ route('index') }}" style="text-decoration: none; color: #00044c"> Клуб любителей творчества «ОчУмелые ручки»</a>
        </div>
        @if(Config::get('user.is_registered'))
            <div class="auth">
                @if(Config::get('user.is_master'))
                    <span class="">Master</span><br>
                @endif
                <span class="">{{ Config::get('user.fio') }}</span>
                <form method="POST" action="{{ route('logoutUser') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="">
                        Выйти
                    </button>
                </form>
            </div>
        @else
            <div class="auth">
                <form method="GET" action="{{ route('login-user') }}" style="width: 100%;">
                    @csrf
                    <button type="submit" class="">
                        Вход
                    </button>
                </form>
{{--                <form method="GET" action="{{ route('register-user') }}" style="width: 100%;">--}}
{{--                    @csrf--}}
{{--                    <button type="submit" class="">--}}
{{--                        Зарегистрироваться--}}
{{--                    </button>--}}
{{--                </form>--}}
{{--            <a href="">Вход</a>--}}
            </div>
        @endif
    </div>
</div>
{{--<div class="row row--nogutter">--}}
{{--    <div class="menu-burger">--}}
{{--        <div class="burger">--}}
{{--            <div></div>--}}
{{--            <div></div>--}}
{{--            <div></div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@yield('line')

@if(session('success'))
    <div class="row row--nogutter top-line">
        <div class="line" style="color: white">{{ session('success') }}</div>
    </div>
@endif

<div class="main">
    <div class="row">
        @yield('content')
    </div>
</div>
@yield('line-two')
<div class="footer">
    <div class="row">
        <div class="row--small grid between">
            <div class="address">Наш адрес: ВДНХ, 120в</div>
            <div class="tel">Тел: 89123456765</div>
            <div class="copy">(с) Copyright, 2017</div>
        </div>
    </div>
</div>
</body>
</html>
