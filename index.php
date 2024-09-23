<?php
date_default_timezone_set('Asia/Yekaterinburg');
$title = "лаб3 варик2";
require_once __DIR__ . '/src/actions/functions.php';
echo '
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>';echo $title;echo '</title>
</head>

<body>
<main>';

echo getHtmlReport();

//    GetTitles($_POST['article'], $_POST['date']);

echo '    
</main>
</body>
</html>';