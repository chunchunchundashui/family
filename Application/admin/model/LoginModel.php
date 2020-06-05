<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/6/12
 * Time: 16:35
 */
include "./Framework/tool/Model.php";
class LoginModel extends Model
{
    public function validate($name,$passwd){
        $sql = "select * from administrators where name='{$name}'";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);  //PDO::FETCH_ASSOC只查询除关联数组
        if($result){
            if ($result['password'] == md5($passwd)){//进行MD5加密之后在比对
                return 1;
            }else{
                return -2;  //自定义-2代表密码错误
            }
        }else{  //用户名不确定
            return -1;  //自定义-1代表用户名错误
        }

    }
}