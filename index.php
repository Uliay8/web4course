<?php
date_default_timezone_set('Asia/Yekaterinburg');
$title = "лаб1";

function tryToConnect($user = "user1", $password = "1", $db = "lab1")
{
    $connection = pg_connect("host=localhost dbname=$db user=$user password=$password");
    if ($connection) {
//        echo "Подключение успешно";
        pg_close($connection);
        header("Location: /tents.php");
        die();
    } else {
        echo "Ошибка: соединение не установлено";
    }
}
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
    <form action="" method="post">
        <h2>Вход</h2>
        <label for="user">
            Имя: <input type="text" id="user" name="user" placeholder="user1" >
        </label><br><br>

        <label for="password">
            Пароль: <input type="password" id="password" name="password" placeholder="******">
        </label><br><br>

        <button type="submit" id="submit">Продолжить</button>
    </form>
    <?php
    if (isset($_POST['user']) && isset($_POST['password'])) {
        @tryToConnect($_POST['user'], $_POST['password']);
    }
    ?>
</main>
</body>
</html>