<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/7/25
 * Time: 9:57
 */
include_once "./Application/admin/controller/BaseController.php";
class UserController extends BaseController
{
    protected $table_name = 'User';

    /*
     * 重写钩子方法
     */
    protected function __data(){
        //查询专业的数据，分配给页面
        include_once "./Application/admin/model/UserModel.php";
        $UserModel = new UserModel();
        $course = $UserModel->select();
        return $course;
//        include_once "./Application/admin/view/{$this->table_name}/save.html";
    }
}