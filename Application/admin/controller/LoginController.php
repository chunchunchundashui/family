<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/6/12
 * Time: 16:13
 */

class LoginController
{
    /*
     * 显示页面
     */
    public function index(){
        include "./Application/admin/view/login/index.html";
    }
    /*
     * 验证用户登录的信息是否正确
     */
    public function verification(){
        $name = isset($_POST['name']) ? $_POST['name'] :'';
        $passwd = isset($_POST['passwd']) ? $_POST['passwd'] :'';
        //接受用户发送过来的请求
        include "./Application/admin/model/LoginModel.php";
        $LoginModel = new LoginModel();
        $result = $LoginModel->validate($name,$passwd);
        if ($result == -1){
            echo json_encode(array('status'=>-1,'msg'=>'用户名错误'));exit;
        }else if ($result == -2){
            echo json_encode(array('status'=>-2,'msg'=>'密码错误'));exit;
        }else{
                setcookie('login','ok',time()+10);
            echo json_encode(array('status'=>1,'url'=>'index.php?m=admin'));exit;
        }
        header("location:index.php?m=admin&c=login");
    }
    public function out(){
        setcookie('login','');
        header("location:index.php?m=admin&c=login");
    }
}