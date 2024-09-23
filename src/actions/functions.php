<?php
function GetTitles($typeArticle, $date)
{
    if ($typeArticle == null || $date == null){
        print_r("Вы не заполнили все параметры");
        return;
    }
    $date = substr($date, 0,4);

    $isPrintedArticle = false;
    $pathToFolders = "src/articles/";
    $descriptorFolders = opendir($pathToFolders);
    if ($descriptorFolders) {
        while (($toFolder = readdir($descriptorFolders)) !== false) {
            if($toFolder=='.' || $toFolder=='..') continue;
            $pathToArticles = $pathToFolders . $toFolder . '/';
            $descriptorArticles = opendir($pathToArticles);
            if($descriptorArticles) {

                while (($toArticle = readdir($descriptorArticles)) !== false) {
                    if($toArticle=='.' || $toArticle=='..') continue;
                    $pattern = $typeArticle . "\w+\.txt"; //отбирает статьи sport__.__ или tech__.__
                    if (preg_match("($pattern)", $toArticle)) {

                        $str = htmlentities(file_get_contents($pathToArticles . $toArticle));
                        if (preg_match("($date)", $str)) {
                            $isPrintedArticle = true;
                            $file = fopen($pathToArticles . $toArticle, 'r') or die("не удалось открыть файл");
                            $str = htmlentities(fgets($file));
                            echo $str . "<br><br>";
                            fclose($file);
                        }
                    }
                }
                //closedir($descriptorArticles);
            }
        }
        if (!$isPrintedArticle) {
            echo "Найдено 0 статей";
        }
        //closedir($descriptorFolders);
    }
}

function getHtmlReport() {
    $array = getReport();
    $statisticsPeople = getStatisticsPeople();
    echo '<h4>Проверка на ошибки:</h4>';
    echo '<p>Количество исправленных ошибок в телефонах: ' . $array[0] . '</p>';
    echo '<p>Количество исправленных ошибок в адресах: ' . $array[1] . '</p>';
    echo '<p>-----</p>';
    echo '<p>Данные (пол, адрес, дата рождения) преобразованы в новый формат!</p>';
    echo '<p>Данные записаны в файл newBase.txt (в качестве разделителя использована точка с запятой)</p>';
    echo '<h4>Подведена следующая статистика: </h4>';
    echo '<p>Имя, телефон, адрес самого пожилого человека: </br>';
    echo $statisticsPeople[0][0] . ' ' . $statisticsPeople[0][1] . ' ' . $statisticsPeople[0][2] . '</p>';
    echo '<p>Имя, телефон, адрес самого молодого человека: </br>';
    echo $statisticsPeople[1][0] . ' ' . $statisticsPeople[1][1] . ' ' . $statisticsPeople[1][2] . '</p>';
    echo '<p>Количество клиентов для каждого почтового сервиса:';
    getStatisticsEmail();
    echo '</p>';
}

function getReport(): array
{
    $countPhoneErrors = 0;
    $countAddressErrors = 0;

    $file = fopen('src/OLDBASE.txt', 'r');
//    $file = fopen('src/test.txt', 'r');
    $newFile = fopen('src/newBase.txt', 'w');
    if ($file) {
        echo '<p>';
        while (($line = fgetcsv($file)) !== false) {
            //Убираем спецсимволы, проверяем количество параметров и номер строки
            $line = preg_replace('/[^a-zA-Z0-9_ &$#*()\[\].,\/@-]/', '', $line);
            $numParameters = count($line);
            if ($numParameters != 17 || preg_match("/^([0-9]{1,5})$/", $line[0])==0) {
                continue;
            }
            // присваеваем переменные и работаем с ними
            list($id, $firstName, $middleInitial, $lastName, $gender, $city, $region, $email, $phone, $birthDate,
                $post, $company, $weight, $height, $address, $postalCode, $countryCode) = $line;

            // проверка ошибок и поддсчёт
            $array = editPhone($phone);
            if ($array[1] > 0) {
                $countPhoneErrors += 1;
                $phone = $array[0];
            }
            $array = editAddress($address);
            if ($array[1] > 0) {
                $countAddressErrors += 1;
                $address = $array[0];
            }

            //Преобразование данных в новый формат
            $gender = convertGender($gender);
            $birthDate = convertDate($birthDate);
            $address = convertAddress($address);

            //Перезаписываем в новый файл
            $newLine = "$id;$firstName;$middleInitial;$lastName;$gender;$city;$region;$email;$phone;$birthDate;$post;$company;$weight;$height;$address;$postalCode;$countryCode\n";
            fwrite($newFile, $newLine);
//            echo $newLine. "<br>";

//            echo $id ."; " . $address . "; " . $birthDate . "<br>";

//            echo $id . ", " . $firstName . ", " . $middleInitial . ", " . $lastName . ", " . $gender . "5, " . $city . ", " .
//                $region . ", " . $email . ", " . $phone . ", " . $birthDate . "10, " . $post . ", " . $company . ", " .
//                $weight . ", " . $height . ", " . $address . "15, " . $postalCode . ", " . $countryCode . '17<br>';
        }
        fclose($file);
        fclose($newFile);
    }
    else {
        echo "Ошибка открытия файла!";
    }

    return array($countPhoneErrors, $countAddressErrors);
}

function getStatisticsPeople(): array {
    $birthDateOld = date_create();
    $arrayForOld = array();
    $birthDateYoung = date_sub(date_date_set(date_create(), 2020,01, 01),
        date_interval_create_from_date_string("400 years"));
    $arrayForYoung = array();
    $file = fopen('src/newBase.txt', 'r');
    if ($file) {
        while (($line = fgetcsv($file, null, ';')) !== false) {
            list($id, $firstName, $middleInitial, $lastName, $gender, $city, $region, $email, $phone, $birthDate,
                $post, $company, $weight, $height, $address, $postalCode, $countryCode) = $line;
            if ($birthDateOld > date_create_from_format('d.m.Y', $birthDate)) {
                $birthDateOld = date_create_from_format('d.m.Y', $birthDate);
                $arrayForOld = array($firstName, $phone, $address);
            }
            if ($birthDateYoung < date_create_from_format('d.m.Y', $birthDate)) {
                $birthDateYoung = date_create_from_format('d.m.Y', $birthDate);
                $arrayForYoung = array($firstName, $phone, $address);
            }
        }
        fclose($file);
    } else {
        echo "Ошибка открытия файла!";
    }
    return array($arrayForOld, $arrayForYoung);
}

function getStatisticsEmail(){

}

function editPhone($phone): array
{
//    $pattern = '/\b\d{2,3}-\d{2,3}-\d{4}\b/';
//    $cleanPattern = '/[^0-9\-]/';
//    $cleanText = preg_replace($cleanPattern, '', $phone);
//    preg_match($pattern, $cleanText, $matches);
//    return $matches[0];
//    $pattern = "/(\S+)-(\S+)-(\S+)/"; //\S+
    $count = 0;
    $pattern = "/[^0-9-]/";
    $replace = '';
    $newPhone = preg_replace($pattern, $replace, $phone, -1, $count);
    return array($newPhone, $count);
}
function editAddress($address): array
{
    $count = 0;
    $pattern = "/([0-9]+)[\s_&$#*()\[\].,@-]*([\w\s_&$#*()\[\].,@-]+)/";
    $addressNumber = preg_replace($pattern, '\1', $address);
    $addressStreet = preg_replace($pattern, '\2', $address);
    $pattern = "/[0-9_&$#*()\[\].,@-]/";
    $addressStreet = preg_replace($pattern, '', $addressStreet);

    $newAddress = $addressNumber . ' ' . $addressStreet;
    if ($newAddress!=$address) {
        $count +=1;
    }
    return array($newAddress, $count);
}

function convertGender($gender): string
{
    return $gender == 'male' ? '1' : ($gender == 'female' ? '0' : 'not specified');
    //там 3 not specified
}

function convertDate($birthDate){
    // m/d/y
    $pattern = '/\b(\d{1,2})\/(\d{1,2})\/(\d{4})\b/';
    return preg_replace_callback($pattern, "formatDate", $birthDate);
}
function formatDate($matches): string
{
    $month = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
    $day = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
    $year = $matches[3];
    return "$day.$month.$year";
}

function convertAddress($address){
    $pattern = '/^(\d+)\s([a-zA-Z\s]+)/';
    return preg_replace_callback($pattern, function ($matches) {
        $number = $matches[1];
        $street = $matches[2];
        return "$street, $number";
    }, $address);
}

