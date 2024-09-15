<?php
date_default_timezone_set('Asia/Yekaterinburg');
$title = "лаб1";
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
</head>

<body>
<main>
    <form action="src/actions/login.php" method="post">
        <h2>Вход</h2>
        <label for="user">
            Имя: <input type="text" id="user" name="user" placeholder="user1" >
        </label><br><br>

        <label for="password">
            Пароль: <input type="password" id="password" name="password" placeholder="******">
        </label><br><br>

        <button type="submit" id="submit">Продолжить</button>
    </form>
</main>
</body>
</html>