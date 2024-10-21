<?php
 $content = file_get_contents("html.html");

$connection = pg_connect("host=localhost dbname=lab5 user=postgres password=postgres");

if (!$connection) {
    echo "Ошибка: соединение не установлено";
    die();
}

$operators = '';
$arrayNonUniqueOperators = [];
$sql = "SELECT operator FROM rates ;";
$result = pg_query($connection ,$sql);
if ($result) {
    $result_array = pg_fetch_row($result);
    if ($result_array[0] == "") {
        echo "Ошибка (не найдены операторы)";
    } else {
        do {
            $arrayNonUniqueOperators[] = $result_array[0];
        } while ($result_array = pg_fetch_row($result));
    }
} else {
    echo "Произошла ошибка запроса";
}
$arrayUniqueOperators = array_unique($arrayNonUniqueOperators);
foreach ($arrayUniqueOperators as $operator) {
    $operators .= '<option value="' . $operator . '">' . $operator . '</option>';
}
$content = str_replace('{{ operator }}', $operators, $content);


$cities = '';
$arrayNonUniqueCities = [];
$sql = "SELECT city FROM rates ;";
$result = pg_query($connection ,$sql);
if ($result) {
    $result_array = pg_fetch_row($result);

    if ($result_array[0] == "") {
        echo "Ошибка (не найдены города)";
    } else {
        do {
            $arrayNonUniqueCities[] = $result_array[0];
        } while ($result_array = pg_fetch_row($result));
    }
} else {
    echo "Произошла ошибка запроса";
}
$arrayUniqueCities = array_unique($arrayNonUniqueCities);
foreach ($arrayUniqueCities as $city) {
    $cities .= '<option value="' . $city . '">' . $city . '</option>';
}
$content = str_replace('{{ city }}', $cities, $content);

pg_close($connection);
echo $content;