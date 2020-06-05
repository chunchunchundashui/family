<?php
header("Content-type:text/html;charset=utf-8");
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/5/27
 * Time: 10:18
 */
class db
{
    //设置成员变量
    private $host;          //链接地址
    private $db_name;       //连接名称
    private $username;      //数据库的用户名
    private $passwd;      //数据库的密码
    public $link;  //连接数据库的静态变量
    private static $home;  //
    /*
    *   构造函数
    */
    public function __construct($config)
    {
        $this->host       = isset($config['host'])      ?   $config['host']         :   '127.0.0.1';  //主机名，地址
        $this->db_name   = isset($config['db_name'])    ?   $config['db_name']     :   'family'; //数据库名称
        $this->username  = isset($config['username'])   ?   $config['username']   :     'root';//用户名
        $this->passwd  =  isset($config['passwd'])      ?    $config['passwd']   :   '123456';//密码
        $this->conn();
    }


    //连接数据库
    public function conn(){
        $this->link = new PDO(
            "mysql:host=$this->host;dbname=$this->db_name",
            $this->username,
            $this->passwd
        );
    }
    //连接数据库的参数
    public static function getMessage($config){
        if (!(self::$home instanceof self)){
            self::$home =  new self($config);
        }
        return self::$home;
    }
    //数据库查看
    public function select($table,$start,$pageSize){
        $sql = "select * from `{$table}` order by id asc limit $start,$pageSize";
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC只查询除关联数组
        return $result;
    }
    public function select_one($table,$id=''){
        $where = '';
        if (!empty($id)){
            $where = "where id = $id";
        }
        $sql = "select * from `{$table}` $where";
//var_dump($sql);die;
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        //PDO::FETCH_ASSOC只查询除关联数组
        return $result;
    }
    /*
     * 查询数据表中的总条数
     */
    public function count($table){
        $sql = "select count(*) as count from `{$table}`";
        $sth = $this->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    //数据库删
    public function del($table,$id){
        $this->link;
        $sql = "delete from `{$table}` where id={$id}";
        $this->link->exec($sql);
    }
    //假数据库删
    public function status($table,$id){
        $sql = "update `{$table}` set status='0' where id={$id}";
//        var_dump($sql);die;
        $result =  $this->link->exec($sql);
        return $result;
    }
    //数据库改
    public function update($table,$data){
        $id=$data['id'];
        unset($data['id']);
        $sql = "update `{$table}` set ";
        $this->link->exec($sql);
        $ma = '';
        foreach ($data as $k=>$v){
            $ma .=$k.'='."'$v'".',';
        }
        $sql .=substr($ma,0,-1);
        $sql .=" where id = $id";
//        var_dump($sql);die;
        $result = $this->link->exec($sql);
        return $result?1:0;
    }

    //数据库增加
    public function  add($table,$data){
        //拼接sql语句
        $sql = "insert into `{$table}`(";
        $key_data = array_keys($data);
        foreach ($key_data as &$dongshao){
            $dongshao = '`'.$dongshao.'`';
        }
        //先将数组中的键取出来array_keys,在将数组转成字符串implode：数组转字符串
        $sql .= implode(',',$key_data).') values(';
        //先将数组中的值取出来array_values(),,使用array_map回调函数给每个值加上一个单引号
        $arr = array_map(function ($v){ return "'$v'";},array_values($data));
        //再将数组转成字符串
        $sql .= implode(',',$arr).")";
//        var_dump($sql);die;
        $result = $this->link->exec($sql);
        //var_dump($result);die;
        return $result;
    }
    public function __clone()
    {

    }
}


