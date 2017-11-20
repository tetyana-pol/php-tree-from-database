<?php
/**
* Основные функции
*/

//соединени с базой данных
function db($host,$user,$pass,$database) {
	$db = mysql_connect($host,$user,$pass);
	if (!$db) {
		exit('WRONG CONNECTION');
	}
	if(!mysql_select_db($database,$db)) {
		exit('WRONG DATABASE');
	}
	mysql_query('SET NAMES utf8');
}

//Функция получения массива каталога
function get_cat() {
	//запрос к базе данных
	$sql = "SELECT * FROM employee";
	$result = mysql_query($sql);
	if(!$result) {
		return NULL;
	}
	$arr_cat = array();
	if(mysql_num_rows($result) != 0) {
		
		//В цикле формируем массив
		for($i = 0; $i < mysql_num_rows($result);$i++) {
			$row = mysql_fetch_array($result,MYSQL_ASSOC); 
			if (is_null($row['parent_id'])) {$row['parent_id']=0;} 
			//Формируем массив где ключами являются адишники на родительские категории
			if(empty($arr_cat[$row['parent_id']])) {
				$arr_cat[$row['parent_id']] = array();
			}	
			$arr_cat[$row['parent_id']][] = $row;	
		} 
		
		
		//возвращаем массив
		return $arr_cat;
	}
}	

//вывод каталогa с помощью рекурсии		
function view_cat($arr, $parent_id = 0) {

	//Условия выхода из рекурсии
	if(empty($arr[$parent_id])) {
		return;
	}
	echo '<ul>';
	//перебираем в цикле массив и выводим на экран
	for($i = 0; $i < count($arr[$parent_id]);$i++) {
		echo '<li>'.$arr[$parent_id][$i]['fio'];
		//рекурсия - проверяем нет ли дочерних категорий
		view_cat($arr,$arr[$parent_id][$i]['id']);
		echo '</li>';
	}
	echo '</ul>';
	
}
?>