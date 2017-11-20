<?php
/**
* Основная точка входа
*/

//Отправляем заголовок с кодировкой
header("Content-Type:text/html;charset=utf8");

//Подключаем файл с функциями и файл конфигурации
include 'functions.php';
include 'config.php';

//соединение с базой данных
db(HOST,USER,PASS,DB); 

//получаем массив каталога
$result = get_cat();
//Выводи каталог на экран с помощью рекурсивной функции
echo 
view_cat($result);

?>