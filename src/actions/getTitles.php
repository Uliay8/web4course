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