<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/7/25
 * Time: 10:03
 */
include_once "./Application/admin/model/BaseModel.php";
class UserModel extends  BaseModel
{
    protected $table_name = 'user';

    /*
     *  重构getList放法
     */
    /*
     * 内容数据查询功能
     */
    public function getList($start,$pageSize){
        $sql = "select id,`user`,`sex`,`mail`,`status`,create_time from user";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC只查询除关联数组
        return $result;
    }
}