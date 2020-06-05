<?php
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/10
 * Time: 10:28
 */
include "./FrameWork/Tool/Model.php";
class EnterController extends Model
{
    public function index(){
        $user = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $sql = "select * from user where `user` = '{$user}'";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        if ($result){
            if ($result['password'] == $password){
                if ($result['status'] == 0){
                    echo "<script>alert('该账号无法登录!');history.back();</script>";
                    header("location:index.php?m=home&c={$this->table_name}");exit;
                }else
                    setcookie('user',$user);
                    header("location:index.php?m=home");exit;
            }elseif($result['password'] != $password){
                echo "<script>alert('密码错误!');history.back();</script>";
            }
        }else{
            echo "<script>alert('账号不存在!');history.back();</script>";
        }
    }
    public function save($table,$data){
        $result = $this->db->plus($table,$data);
        return $result;
    }
}