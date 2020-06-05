<?php
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/15
 * Time: 8:33
 */
include "./FrameWork/Tool/Model.php";
class libraryController extends Model
{
    protected $diploma='',$library='',$subject='';
    public function index(){
        if ($this->diploma != ''){
            $sql = "select * from `teacher` WHERE diploma LIKE \"%$this->diploma%\"";
        }elseif($this->subject == 'music'){
            $sql = "select * from `teacher` WHERE subject LIKE \"%琴%\"";
        } elseif($this->subject==''&& $this->diploma == ''){
            $sql = "select * from `teacher`";
        }else
            $sql = "select * from `teacher` WHERE subject LIKE \"%$this->subject%\"";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        $page = isset($_GET['page']) ? $_GET['page'] : 1 ;//传入页面就使用page,没有就1
        $sql = "select count(*) as count from `order`";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $count = $sth->fetch(PDO::FETCH_ASSOC);
        $pageSize = 15;//每页的条数
        $start = ceil(($page-1)*$pageSize);
        include "./Framework/tool/PageTool.class.php";
        $PageHtml = PageTool::show("index.php?m=home&c={$this->library}",$count['count'],$pageSize,$page);
        include_once "./Application/home/view/index/{$this->library}teacher.html";
    }
}