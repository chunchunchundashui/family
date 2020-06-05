<?php
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/16
 * Time: 8:57
 */
include_once "./Framework/tool/Model.php";
class IndexLibraryController extends Model
{
    public function index(){
        $sql = "select a.*,b.sex as user_sex,b.id as user_id from `order` as a
                join `user` as b on a.user_name = b.user ORDER BY b.`user` DESC LIMIT 15";
//        ORDER BY `user`.id DESC
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $users = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sql = "select * from `teacher` WHERE diploma LIKE \"%教师%\" order by id desc LIMIT 15";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $majors = $sth->fetchAll(PDO::FETCH_ASSOC);
        $sql = "select * from `teacher` WHERE diploma LIKE \"%学生%\" order by id desc LIMIT 15";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $universities = $sth->fetchAll(PDO::FETCH_ASSOC);
        include_once "./Application/home/view/login/index.html";
    }
}