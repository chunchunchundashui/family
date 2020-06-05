<?php
header("Content-type:text/html;charset=utf-8");
$m = isset($_GET['m']) ? $_GET['m'] : 'home';
$c = isset($_GET['c']) ? $_GET['c'] : 'indexLibrary';
define('CONTROLLER_NAME',$c);

$controller_name = $c.'Controller';
//引入要创建对象的类
include "./Application/{$m}/controller/{$c}Controller.php";

//创建类对象
$home_controller = new $controller_name();

$a = isset($_GET['a']) ? $_GET['a'] : 'index';

$home_controller->$a();























