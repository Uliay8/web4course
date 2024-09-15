<?php
function Autorization($user = "user1", $password = "1", $db = "lab1")
{
    $connection = pg_connect("host=localhost dbname=$db user=$user password=$password");
    if($connection){

        echo "Подключение успешно";
//        require('functions.php');
        pg_close($connection);
//        sleep(3);
//        header("Location: /functions.php");
//        die();
    }
    else
    {
        die("Ошибка: соединение не установлено");
    }
}

$user = $_POST['user'];
$password = $_POST['password'];
Autorization($user, $password);
//usleep(3000000);
//header("Location: functions.php");
require('../../tents.php');