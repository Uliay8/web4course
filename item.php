<?php
require 'html.php';

$title = "Описание палатки";
$page = new HTMLPage($title);

$name = isset($_GET['namet']) ? $_GET['namet'] : '';
$tent = $page->getTentByNameTent($name);

if ($tent) {
    $content = "<h2>{$tent[0]}</h2>
                <p><strong>Производитель:</strong> {$tent[1]}</p>
                <p><strong>Тип:</strong> {$tent[2]}</p>
                <p><strong>Мест:</strong> {$tent[3]}</p>
                <p><strong>Описание:</strong> {$tent[4]}</p>
                <img src='src/вар3/{$tent[5]}' alt='Фото палатки' class='tent-image' />";
} else {
    $content = "<p>Палатка не найдена.</p>";
}

$page->write($content);