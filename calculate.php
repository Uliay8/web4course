<?php
$connection = pg_connect("host=localhost dbname=lab5 user=postgres password=postgres");

if (!$connection) {
    echo "Ошибка: соединение не установлено";
    die();
}

if (isset($_GET['operator'])) {
    $operator = $_GET['operator'];
    $city = $_GET['city'];
    $time = $_GET['time'];
    $sql = "SELECT rate FROM rates WHERE operator = '$operator' AND city = '$city';";
    $result = pg_query($connection, $sql);
    if ($result) {
        $result_array = pg_fetch_row($result);
        if ($result_array == "") {
            echo "Ошибка (не найдено такого тарифа)";
        } else {
            do {
                $cost = $result_array[0] * $time;
                echo number_format($cost, 2, '.', '');
            } while ($result_array = pg_fetch_row($result));
        }
    } else {
        echo "Произошла ошибка запроса";
    }
}
pg_close($connection);