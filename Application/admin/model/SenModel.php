<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/8/2
 * Time: 10:41
 */
include_once "./Framework/tool/Model.php";
class SenModel extends Model
{
    public function index($name)
    {
        $sql = "select * from user where user like '%{$name}%'";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC只查询除关联数组
        return $result;
    }
}