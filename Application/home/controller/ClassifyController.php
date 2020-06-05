<?php
header("Content-type:text/html;charset=utf-8");
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/18
 * Time: 9:50
 */
include "./FrameWork/Tool/Model.php";
class ClassifyController extends Model
{
    protected $type='';
    public function index(){
        $name = isset($_GET['n']) ? $_GET['n'] : '';
        $sql = "select * from `teacher` WHERE {$this->type} LIKE \"%$name%\"";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
        $page = isset($_GET['page']) ? $_GET['page'] : 1 ;//传入页面就使用page,没有就1
        $sql = "select count(*) as count from `teacher` where {$this->type} LIKE \"%$name%\"";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $count = $sth->fetch(PDO::FETCH_ASSOC);
        $pageSize = 15;//每页的条数
        $start = ceil(($page-1)*$pageSize);
        include "./Framework/tool/PageTool.class.php";
        $PageHtml = PageTool::show("index.php?m=home&c={$this->type}Classify",$count['count'],$pageSize,$page);
        include_once "./Application/home/view/content/Classify/Classify.html";
    }
}