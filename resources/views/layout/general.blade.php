{{--<!DOCTYPE html>--}}
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel=stylesheet href='/../style.css' type='text/css'>
    <title>Резюме и вакансии </title>
</head>
<body>
<div class="header"><!--*****************Логотип и шапка********************-->
    Резюме и вакансии<div id="logo"></div>
</div>

    @yield('content') <!-- Здесь будет изменяемое содержимое -->


<div class="rightcol"><!--*******************Навигационное меню*******************-->
    <ul class="menu">
        <li><a href="">Вакансии</a></li>
        <li><a href="">Резюме по профессиям</a></li>
        <li><a href="">Резюме по возрасту</a></li>
        <li><a href="">Избранное резюме</a></li>
    </ul>
</div>
<div class="footer" ><p>&copy; Copyright 2017</p></div>
</body>
</html>
