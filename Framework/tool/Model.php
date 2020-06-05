<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/5/31
 * Time: 11:04
 */

class Model
{
    //定义一个属性，方便子类继承
    public $db;
    //使用构造函数，初始化属性
    public function __construct()
    {
        $this->init();
    }
    public function init(){
        include_once './Framework/tool/db.php';
        $this->db = db::getMessage(array('db_name'=>'family','username'=>'root','password'=>'123456'));
    }
}