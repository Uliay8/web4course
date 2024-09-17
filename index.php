<?php
date_default_timezone_set('Asia/Yekaterinburg');
$title = "лаб2";
require_once __DIR__ . '/src/actions/getTitles.php';

echo '
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>';echo $title;echo '</title>
</head>

<body>
<main>
    <h3>Статьи:</h3>
    <form method="post" action="">
        <label for="article"> Рубрика:<br>
            <input type="radio" name="article" value="tech" />Технологии <br>
            <input type="radio" name="article" value="sport" />Спорт <br>
        </label>
        <input type="date" id="date" name="date"><br>
        <button type="submit" id="submit">Вывести заголовки</button>
    </form>';

    if(isset($_POST['article']) || isset($_POST['date'])) {
        @GetTitles($_POST['article'], $_POST['date']);
    }

echo '    
</main>
</body>
</html>';