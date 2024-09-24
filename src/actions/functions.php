<?php

function GetNameAndImageByCompany($company = "Green Land")
{
    if (empty($company)){
        echo "Введите компанию";
        return;
    }
    $path = 'src/вар3/';
    $connection = pg_connect("host=localhost dbname=lab1 user=postgres password=postgres");
    $sql = "SELECT namet, SUBSTRING(imageName,1,LENGTH(imageName)-1) FROM tents WHERE country = '$company';";
    $result = pg_query($connection, $sql);
    if($result){
        $result_array = pg_fetch_row($result);
        if ($result_array[0]=="") {
            echo "Не найдено";
        } else {
            do {
                echo 'Название палатки: ' . $result_array[0] ."<br>". 'Изображение:' ."<br>";
                $file = $path . $result_array[1];
                echo '<a><img src=' . $file . '></a><br>';
            } while ($result_array = pg_fetch_row($result));
        }

    }
    else{
        echo "Произошла ошибка запроса";
    }
    pg_close($connection);
}

function GetDescriptionByCapacity($capacity=4)
{
    if (empty($capacity)){
        echo "Введите количество мест";
        return;
    }
    $connection = pg_connect("host=localhost dbname=lab1 user=postgres password=postgres");;
    $sql = "SELECT description FROM tents WHERE capacity = $capacity;";
    $result = pg_query($connection ,$sql);
    if($result){
        $result_array = pg_fetch_row($result);
        if ($result_array[0]=="") {
            echo "Не найдено";
        } else {
            do {
                echo 'Описание для палатки с вместимостью до ' . $capacity . ' человек:' . "<br>" . $result_array[0] . "<br><br>";
            } while ($result_array = pg_fetch_row($result));
        }
    }
    else {
        echo "Произошла ошибка запроса";
    }
    pg_close($connection);
}