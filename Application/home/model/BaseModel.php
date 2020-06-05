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
        $id = isset($data['id']) ? $data['id']:'';
        if (empty($id)){
            if (isset($data['from']) && $data['from'] == 'order'){
                unset($data['from']);
                if (isset($data['name'],$data['sex'],$data['area'],$data['addarea'],$data['grade'],$data['resume'],$data['money'],$data['time']
                    ,$data['phone'],$data['subject'],$data['require'],$data['user_name'])){
                    if ($data['name'] == '' || $data['sex'] == '' || $data['area'] == '' || $data['addarea'] == '' || $data['grade'] == '' ||
                        $data['resume'] == '' ||  $data['money'] == '' ||   $data['time'] == '' || $data['phone'] == ''|| $data['subject'] == ''
                        || $data['require'] == '' || $data['user_name'] == '' ){
                        echo '不行';
                        header("refresh:2;url=index.php?m=home&c={$this->table_name}");exit;
                    }else{
                        $data['area'] = $data['area'].''.$data['addarea'];
                        $data['status'] = 1;
                        unset($data['addarea']);
                    }
                }else{
                    include_once "./Application/home/view/index/{$this->table_name}_loser.html";exit;
                }
            }elseif (isset($data['from']) && $data['from'] == 'teacher'){
                unset($data['from']);
            } else{
                if (isset($data['user'],$data['passwd'],$data['passwd2'],$data['mail'],$data['sex'])){
                    if ($data['user'] == '' || $data['passwd'] == '' || $data['passwd2'] == '' || $data['mail'] == ''|| $data['sex'] == ''){
                        include_once "./Application/home/view/index/{$this->table_name}_loser.html";exit;
                    }else{
                        $data['password'] = $data['passwd2'];
                        unset($data['passwd'],$data['passwd2']);
                    }
                }else{
                    include_once "./Application/home/view/index/{$this->table_name}_loser.html";exit;
                }
            }
            //连接数据库，进行数据库添加
            unset($data['id']);
            $data['create_time'] = time();
            $data['status'] = 1;
            $result = $this->db->add($this->table_name,$data);
        }else{
            if (empty($data['password']))  unset($data['password']);
            $result = $this->db->update($this->table_name,$data);
        }
        return $result;
    }
    public function count(){
        $rows = $this->db->count($this->table_name);
        return $rows;
    }
    public function select_two($table,$id){
        $rows = $this->db->select_one($table,$id);
        return $rows;
    }
}