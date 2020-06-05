<?php
header("Content-type:text/html;charset=utf-8");
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/16
 * Time: 15:52
 */
include_once "./Framework/tool/Model.php";
class DetailedController extends Model
{
    public function index(){
        include_once "./Application/home/model/BaseModel.php";
        $model = new BaseModel();
        if ($_GET['t'] == 'teacher'){
            $row = $model->select_two($_GET['t'],$_GET['id']);
          // var_dump($row);die;
            $sql = "select * from `teacher` WHERE subject LIKE '%{$row['subject']}%' and id != {$row['id']} order by id desc LIMIT 8";
            $sth = $this->db->link->prepare($sql);
            $sth->execute();
            $teachers = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC只查询除关联数组
            include_once "./Application/home/view/content/Detailed/detailed.html";
        }elseif ($_GET['t'] == 'user'){
            $sql = "SELECT a.id as user_id,a.user as user_name,a.sex as user_sex,b.* FROM `user` AS a , `order` AS b WHERE a.id = {$_GET['id']} AND a.`user` = b.user_name";
            $sth = $this->db->link->prepare($sql);
            $sth->execute();
            $row = $sth->fetch(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC只查询除关联数组
           // var_dump($row);die;
            $sql = "SELECT a.id as user_id,b.* FROM `user` AS a , `order` AS b WHERE a.id != {$row['user_id']} AND b.status != 0 AND a.`user` = b.user_name";
            $sth = $this->db->link->prepare($sql);
            $sth->execute();
            $users = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC只查询除关联数组
            include_once "./Application/home/view/content/Detailed/UserDetailed.html";
        }
    }
}