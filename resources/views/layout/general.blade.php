

<!DOCTYPE html>
<html lang="en">{{--class="no-js"--}}
<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Новости науки</title>
    <link rel="stylesheet" href="{{ asset('stylesheets/foundation.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stylesheets/main.css') }}">
    <link rel="stylesheet" href="{{ asset('stylesheets/app.css') }}">
    <script src="{{ asset('javascripts/modernizr.foundation.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('fonts/ligature.css') }}">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Playfair+Display:400italic' rel='stylesheet' type='text/css' />
{{--    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>--}}
</head>
<body>
<nav>
    <div class="twelve columns header_nav">
        <div class="row">
            <ul id="menu-header" class="nav-bar horizontal">
                <li><a href="{{ route('index') }}">Главная</a></li>
                @foreach($rubrics as $rubric)
                    <li><a href="{{ route('rubrika', $rubric->id) }}">{{ $rubric->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="">
        @if(Config::get('user.is_admin'))
            <span class="">Admin</span>
        @endif
        <span class="">{{ Config::get('user.name') }}</span>
        <form method="POST" action="{{ route('logoutUser') }}">
            @csrf
            <button type="submit" class="">
                Выйти
            </button>
        </form>
    </div>

</nav>
<header>
    @yield('header')
</header>

<main>
    @yield('content')
{{--    <section>--}}
{{--        <div class="section_dark">--}}
{{--            <div class="row">--}}
{{--                <h2></h2>--}}
{{--                <div class="two columns">--}}
{{--                    <img src="images/thumb1.jpg" alt="desc" />--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}

</main>
<footer>
    <div class="row">
        <div class="twelve columns footer">
            <a href="https://twitter.com/" class="lsf-icon" style="font-size:16px; margin-right:15px" title="twitter">Twitter</a>
            <a href="https://facebook.com/" class="lsf-icon" style="font-size:16px; margin-right:15px" title="facebook">Facebook</a>
            <a href="https://pinterest.com/" class="lsf-icon" style="font-size:16px; margin-right:15px" title="pinterest">Pinterest</a>
            <a href="https://instagram.com/" class="lsf-icon" style="font-size:16px" title="instagram">Instagram</a>
        </div>
    </div>
</footer>
<script src="{{ asset('javascripts/foundation.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('javascripts/app.js') }}" type="text/javascript"></script>
</body>
</html>
