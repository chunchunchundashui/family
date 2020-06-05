<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/7/9
 * Time: 13:17
 */
header("Content-type:text/html;charset=utf-8");
class indexController
{
    public function user(){
        include_once "./Application/home/view/index/user.html";
    }
    public function teacher(){
        include_once "./Application/home/view/index/teacher.html";
    }
    public function chargeStandard(){
        include_once "./Application/home/view/index/chargeStandard.html";
    }
    public function StudentMoney(){
        include_once "./Application/home/view/index/StudentMoney.html";
    }
    public function JiaoYuanMoney(){
        include_once "./Application/home/view/index/JiaoYuanMoney.html";
    }
    public function winCase(){
        include_once "./Application/home/view/index/winCase.html";
    }
    public function modifier(){
        include_once "./Application/home/view/index/modifier.html";
    }
    public function order(){
        if (isset($_COOKIE['user'])){
            include_once "./Application/home/view/index/order.html";
        }else
            include_once "./Application/home/view/index/login_loser.html";
    }
    public function out(){
        unset($_COOKIE['user']);
        setcookie('user','');
        header("location:index.php?m=home&c=indexLibrary");
    }


    public function Changjianwenti(){
        include_once "./Application/home/view/content/lost/Changjianwenti/{$_GET['n']}.html";
    }
    public function JiaZhangketang(){
        include_once "./Application/home/view/content/lost/JiaZhangketang/{$_GET['n']}.html";
    }
    public function Kaoshijingyan(){
        include_once "./Application/home/view/content/lost/Kaoshijingyan/{$_GET['n']}.html";
    }
    public function Xuexifangfa(){
        include_once "./Application/home/view/content/lost/Xuexifangfa/{$_GET['n']}.html";
    }




//蓝色 最后一行
    public function Jiaoyuansousuo(){
        include_once "./Application/home/view/content/Lostlianjie/Jiaoyuansousuo.html";
    }
    public function Jiaoyuan(){
        include_once "./Application/home/view/content/Lostlianjie/JiaoYuanfenlei.html";
    }
    public function XuexiFangfa1(){
        include_once "./Application/home/view/content/Lostlianjie/XuexiFangfa.html";
    }
    public function KaoshiJingyan1(){
        include_once "./Application/home/view/content/Lostlianjie/KaoshiJingyan.html";
    }
    public function JiaZhangketang1(){
        include_once "./Application/home/view/content/Lostlianjie/JiaZhangketang.html";
    }
    public function JiajiaoXiangguan1(){
        include_once "./Application/home/view/content/Lostlianjie/JiajiaoXiangguan.html";
    }
    public function JiaZhangjingyan1(){
        include_once "./Application/home/view/content/Lostlianjie/JiaZhangjingyan.html";
    }
    public function GuanYuwomen1(){
        include_once "./Application/home/view/content/Lostlianjie/GuanYuwomen.html";
    }public function Changjianwenti1(){
        include_once "./Application/home/view/content/Lostlianjie/Changjianwenti.html";
    }public function HuiKuaifangshi1(){
        include_once "./Application/home/view/content/Lostlianjie/HuiKuaifangshi.html";
    }public function Lianxiwomen1(){
        include_once "./Application/home/view/content/Lostlianjie/Lianxiwomen.html";
    }public function Zhaopin1(){
        include_once "./Application/home/view/content/Lostlianjie/Zhaopin.html";
    }
}