<?php
require_once __DIR__ . '/src/actions/functions.php';

echo '<!DOCTYPE html>
<html>
<head>
    <title>Справочник</title>
    <meta charset="utf-8" />
</head>
<body>
<form action="" method="post">
    <h2>Введите компанию: </h2>
    <label for="company">
        Имя: <input type="text" id="company" name="company" placeholder="Green Land" >
    </label><br><br>
    <button type="submit" id="submit">Найти</button>
</form>';
 if (isset($_POST['company'])) {
    GetNameAndImageByCompany($_POST['company']); }

 echo '
<form action="" method="post">
    <h2>Введите количество мест: </h2>
    <label for="capacity">
        Имя: <input type="text" id="capacity" name="capacity" placeholder="4" >
    </label><br><br>
    <button type="submit" id="submit">Найти</button>
</form>';
if (isset($_POST['capacity'])) {
    GetDescriptionByCapacity($_POST['capacity']);}

 echo '</body>
        </html>';