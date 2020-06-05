<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/6/18
 * Time: 17:09
 */
include_once "./Framework/tool/Model.php";
class BaseModel extends Model
{
    protected $table_name = '';

    public function getList_one($id){
        $rows = $this->db->select_one($this->table_name,$id);
        return $rows;
    }
    /*
     * 数据查询功能
     */
    public function getList($start,$pageSize){
        $rows = $this->db->select($this->table_name,$start,$pageSize);
        return $rows;
    }
    /*
     * 数据添加和修改功能
     */
    public function save($data){
        $date = isset($data['id']) ? $data['id']:'';
        if (empty($date)){
            //连接数据库，进行数据库添加
            unset($data['id']);
            $data['create_time'] = time();
            $result = $this->db->add($this->table_name,$data);
        }else{
            if (empty($data['password']))  unset($data['password']);
            $result = $this->db->update($this->table_name,$data);
        }
        return $result;
    }
    /*
     * 数据删除功能
     */
    public function del(){
        $rows = $this->db->del($this->table_name,$_GET['id']);
        return $rows;
    }
    public function count(){
        $rows = $this->db->count($this->table_name);
        return $rows;
    }
    public function select_one($id){
//        var_dump($id);die;
        $rows = $this->db->select_one($this->table_name,$id);
        return $rows;
    }
    /*
     * 数据删除状态功能
     */
    public function del_to($id)
    {
        $rows = $this->db->status($this->table_name, $id);
//        var_dump($rows);die;
        return $rows;
    }
    public function select(){
        $sql = "select id,professional_Name from {$this->table_name}";
//        var_dump($sql);die;
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC只查询除关联数组
        return $result;
    }
}