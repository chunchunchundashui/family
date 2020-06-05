<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/7/25
 * Time: 10:00
 */
include "./Application/admin/model/BaseModel.php";
class OrderModel extends BaseModel
{
    protected $table_name = 'Order';


    public function getList($start,$pageSize){
        $sql = "select id,`name`,`user_name`,`sex`,`subject`,`area`,`money`,`telephone`,`create_time`,`status` from `order` ";
//        var_dump($sql);die;
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC只查询除关联数组
        return $result;
    }
}