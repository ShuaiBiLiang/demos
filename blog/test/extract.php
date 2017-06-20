<?php

$arr = array(
	'name'=>'Tom',
	'age'=>20,
	'home'=>'China'
);
extract($arr); // 一次得到三个变量
var_dump($name, $age, $home);
