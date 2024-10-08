<?php
class HTMLPage
{
    public $title;
    public $connection;
    public $content;

    // создание и инициализация объекта (установка названия страницы)
    public function __construct($title)
    {
        $this->title = $title;
        $this->connection = pg_connect("host=localhost dbname=lab1 user=postgres password=postgres");
        if ($this->connection) {
            $this->content = file_get_contents('html.html');
        } else {
            echo "Ошибка: соединение не установлено";
            die();
        }
    }

    // вывод шапки
    public function header()
    {
        $this->content = str_replace('{{ header }}', $this->title, $this->content);
    }
    // вывод логотипа сайта
    public function logo()
    {
        $this->content = str_replace('{{ logo }}', 'src/вар3/logo.png', $this->content);
    }

    // вывод подвала с копирайтом
    public function footer()
    {
        $footer = "©2024 Online Tents | All Rights Reserved";
        $this->content = str_replace('{{ footer }}', $footer, $this->content);
    }

    // вывод главного меню сайта
    public function menu()
    {
        $tentsItems = $this->getAllTents();
        $listHtml = '';
        foreach ($tentsItems as $item) {
            $listHtml .= "<li><a href='item.php?namet={$item[0]}'>{$item[0]} {$item[1]}</a></li>";
        }
        $this->content = str_replace('{{ menu }}', $listHtml, $this->content);
    }

    // вывод основного содержания страницы
    public function content($text)
    {
        $this->content = str_replace('{{ content }}', $text, $this->content);
    }
    public function closeConnection()
    {
        pg_close($this->connection);
    }

    // вывод веб-страницы, использующий методы для вывода отдельных элементов веб-страницы
    public function write($content)
    {
        $this->header();
        $this->logo();
        $this->menu();
        $this->content($content);
        $this->footer();
        $this->closeConnection();
        echo $this->content;
    }

    // methods i need
    private function getAllTents(): array
    {
        $sql = "SELECT namet, country FROM tents;";
        $result = pg_query($this->connection ,$sql);
        $tents = array();
        if($result){
            $result_array = pg_fetch_row($result);
            if ($result_array[0]=="") {
                echo "Не найдено";
            } else {
                do {
                    $tents[] = array($result_array[0], $result_array[1]);
                } while ($result_array = pg_fetch_row($result));
            }
        } else {
            echo "Произошла ошибка запроса";
        }
        return $tents;
    }

    public function getTentByNameTent($name)
    {
        $sql = "SELECT * FROM tents WHERE namet = '$name';";
        $result = pg_query($this->connection ,$sql);
        if($result){
            return pg_fetch_row($result);
        }
        else {
            echo "Произошла ошибка запроса";
        }
        return false;
    }
}
