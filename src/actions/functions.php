<?php
function getHtmlReport(): void
{
    $array = getReport();
    $statisticsPeople = getStatisticsPeople();
    $statisticsPeopleOld = $statisticsPeople[0];
    $statisticsPeopleYoung = $statisticsPeople[1];
    $statisticsEmail = getStatisticsEmail();
    $statisticsEmailErrors = $statisticsEmail[0];
    $statisticsEmailServers = $statisticsEmail[1];
    echo '<h4>Проверка на ошибки:</h4>';
    echo '<p>Количество исправленных ошибок в телефонах: ' . $array[0] . '</p>';
    echo '<p>Количество исправленных ошибок в адресах: ' . $array[1] . '</p>';
    echo '<p>-----</p>';
    echo '<p>Данные (пол, адрес, дата рождения) преобразованы в новый формат!</p>';
    echo '<p>Данные записаны в файл newBase.txt (в качестве разделителя использована точка с запятой)</p>';

    echo '<h4>Подведена следующая статистика: </h4>';
    echo '<p>Имя, телефон, адрес самого пожилого человека (самых пожилых): </br>';
    $temp = current($statisticsPeopleOld);
    do {
        echo $temp[0] . ' ' . $temp[1] . ' ' . $temp[2] . '</br>';
    } while ($temp = next($statisticsPeopleOld));
    echo '</p>';
    echo '<p>Имя, телефон, адрес самого молодого человека (самых юных): </br>';
    $temp = current($statisticsPeopleYoung);
    do {
        echo $temp[0] . ' ' . $temp[1] . ' ' . $temp[2]. '</br>';
    } while ($temp = next($statisticsPeopleYoung));
    echo  '</p>';

    echo '<p>Количество клиентов для каждого почтового сервера:</br>';
    echo 'Не удалось распознать почтовый сервер для ' . $statisticsEmailErrors . ' адресов(а)<br>';
    $temp = current($statisticsEmailServers);
    if ($temp) {
        do {
            echo key($statisticsEmailServers) . ': ' . $temp . '</br>';
        } while ($temp = next($statisticsEmailServers));
    }
    echo '</p>';

    echo '<h4>Получить записи всех жителей области: </h4>';
    echo '<form action="" method="get">
        <label for="region">
            Введите регион: <input type="text" id="region" name="region" placeholder="FL" >
        </label><br><br>
        <button type="submit" id="submit">Вывести всех оттуда</button>
    </form><br>';
    if (isset($_GET['region'])) {
        $arrayResidents = getAllResidents($_GET['region']);
        if ($arrayResidents == 0) {
            echo "Введите двухсимвольный код области";
        } elseif ($arrayResidents == -1) {
            echo "Жителей такой области не нашлось..";
        } else {
            echo '<p>Жители региона / области ' . $_GET['region'] . ':<br>';
            printAllResidents($arrayResidents);
            echo '</p>';
        }
    }
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

            //если дата рождения меньше, то человек старше, поэтому в $birthDateOld надо брать меньшую
            if ($birthDateOld >= date_create_from_format('d.m.Y', $birthDate)) {
                if ($birthDateOld > date_create_from_format('d.m.Y', $birthDate)) {
                    $birthDateOld = date_create_from_format('d.m.Y', $birthDate);
                    $arrayForOld = array();
                }
                $tempArray = array($firstName, $phone, $address);
                $arrayForOld[] = $tempArray;
            }

            if ($birthDateYoung <= date_create_from_format('d.m.Y', $birthDate)) {
                if ($birthDateYoung < date_create_from_format('d.m.Y', $birthDate)) {
                    $birthDateYoung = date_create_from_format('d.m.Y', $birthDate);
                    $arrayForYoung = array();
                }
                $tempArray = array($firstName, $phone, $address);
                $arrayForYoung[] = $tempArray;
            }
        }
        fclose($file);
    } else {
        echo "Ошибка открытия файла!";
    }
    return array($arrayForOld, $arrayForYoung);
}

function getStatisticsEmail(): array{
    $emailErrors = 0;
    $arrayEmailServers = array();
    $file = fopen('src/newBase.txt', 'r');
    if ($file) {
        while (($line = fgetcsv($file, null, ';')) !== false) {
            list($id, $firstName, $middleInitial, $lastName, $gender, $city, $region, $email, $phone, $birthDate,
                $post, $company, $weight, $height, $address, $postalCode, $countryCode) = $line;

            $emailServer = findEmailServer($email);
            if ($emailServer == 0) {
                $emailErrors += 1;
            } else {
                if (array_key_exists($emailServer, $arrayEmailServers)) {
                    $arrayEmailServers[$emailServer] += 1;
                } else {
                    $arrayEmailServers[$emailServer] = 1;
                }
            }
        }
        fclose($file);
    } else {
        echo "Ошибка открытия файла!";
    }
    return array($emailErrors, $arrayEmailServers);
}

function getAllResidents($receivedRegion): int|array {
    if ($receivedRegion=='') {
        return 0;
    }
    $arrayResidents = array();
    $isExistsRegion = false;
    $file = fopen('src/newBase.txt', 'r');
    if ($file) {
        while (($line = fgetcsv($file, null, ';')) !== false) {
            list($id, $firstName, $middleInitial, $lastName, $gender, $city, $region, $email, $phone, $birthDate,
                $post, $company, $weight, $height, $address, $postalCode, $countryCode) = $line;

            if ($region==$receivedRegion)  {
                $isExistsRegion = true;
                $date = new DateTime($birthDate);
                $now = new DateTime();
                $interval = $now->diff($date);
                $age = $interval->y;
                $arrayResidents[] = array('firstName' => $firstName, 'lastName' => $lastName,
                    'gender' => $gender, 'age' => $age, 'email' => $email);

            }
        }

        $lastNameColumn  = array_column($arrayResidents, 'lastName');
        $firstNameColumn  = array_column($arrayResidents, 'firstName');
        array_multisort($lastNameColumn, SORT_ASC, $firstNameColumn, SORT_ASC, $arrayResidents);
        fclose($file);
    } else {
        echo "Ошибка открытия файла!";
        return 0;
    }
    if ($isExistsRegion) {
        return $arrayResidents;
    }
    return -1;
}

function printAllResidents($arrayResidents): void{
    $temp = current($arrayResidents);
    do {
        if ($temp['gender'] == '1') {
            echo '<label style="color: blue">' . $temp['firstName'] . '</label>';
        } elseif ($temp['gender'] == '0') {
            echo '<label style="color: hotpink">' . $temp['firstName'] . '</label>';
        } else {
            echo $temp['firstName'];
        }
        echo ' ' . $temp['lastName'] . ' ' . $temp['age'] . ' ' . $temp['email'] . '</br>';
    } while ($temp = next($arrayResidents));
}

function editPhone($phone): array{
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

function convertDate($birthDate): array|string|null{
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

function convertAddress($address): array|string|null{
    $pattern = '/^(\d+)\s([a-zA-Z\s]+)/';
    return preg_replace_callback($pattern, function ($matches) {
        $number = $matches[1];
        $street = $matches[2];
        return "$street, $number";
    }, $address);
}

function findEmailServer ($email): string|int {
    $pattern = '/\b[\w._%$#+-]+@([\w.-]+)\.[A-Za-z]{2,6}\b/';
    $isEmail = preg_match($pattern, $email, $matches);
    if ($isEmail == 1) {
        return $matches[1];
    }
    return 0;
}