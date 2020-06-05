<?php
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/16
 * Time: 8:57
 */
class IndexLibraryController
{
    public function index(){
        if (isset($_COOKIE['login']) && $_COOKIE['login'] == 'ok'){
            include "./Application/admin/view/index/index.html";
        }
        include "./Application/admin/view/login/index.html";
    }
    public function top(){
        include "./Application/admin/view/index/top.html";
    }
    public function menu(){
        include "./Application/admin/view/index/menu.html";
    }
    public function main(){
        include "./Application/admin/view/index/main.html";
    }
}