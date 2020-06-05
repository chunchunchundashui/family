<?php
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/15
 * Time: 9:55
 */
include "./FrameWork/Tool/Model.php";
class ModifierController extends Model
{
    public function index(){
        if (isset($_POST['user'],$_POST['mail']) && $_POST['user'] != '' && $_POST['mail'] != ''){
            $sql = "select password,mail from `user` WHERE `user`='{$_POST['user']}'";
            $sth = $this->db->link->prepare($sql);
            $sth->execute();
            $rows = $sth->fetch(PDO::FETCH_ASSOC);
            if ($rows && $rows['mail'] == $_POST['mail']){
                    include_once "./Application/home/view/index/modifiersuccess.html";exit;
            }else
                include_once "./Application/home/view/index/modifier_loser.html";exit;
        }else
            include_once "./Application/home/view/index/modifier_loser.html";exit;
    }
}