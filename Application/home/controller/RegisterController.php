<?php
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/10
 * Time: 19:34
 */

class RegisterController
{
    public function index(){
        if (isset($_POST['user'],$_POST['passwd'],$_POST['passwd2'],$_POST['identify'],$_POST['accept'])){
            if ($_POST['user'] == '' || $_POST['passwd'] == '' || $_POST['passwd2'] == ''|| $_POST['identify'] == '' || $_POST['accept'] == ''){
                echo '不行';
                header("refresh:2;url=index.php?m=home&c={$this->table_name}");exit;
            }else{
                $data = $_POST;
                if ($_POST['identify'] == '在校大学生'){
                    include_once "./Application/home/view/index/regedit.html";exit;
                }elseif($_POST['identify'] == '在职老师'){
                    include_once "./Application/home/view/index/zaizhilaoshi.html";exit;
                }elseif($_POST['identify'] == '外籍人士'){
                    include_once "./Application/home/view/index/WaiJiRenShi.html";exit;
                }elseif($_POST['identify'] == '其他'){
                    include_once "./Application/home/view/index/other.html";exit;
                }else{
                    include_once "./Application/home/view/index/teacher.html";exit;
                }
            }
        }else
            include_once "./Application/home/view/index/teacher.html";exit;
    }
}