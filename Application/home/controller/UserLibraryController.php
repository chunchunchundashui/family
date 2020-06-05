<?php
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/13
 * Time: 16:55
 */
include "./FrameWork/Tool/Model.php";
class UserLibraryController extends Model
{
    public function index(){
        $sql = "select a.*,b.sex as user_sex,b.id as user_id from `order` as a
                join `user` as b on a.user_name = b.user";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll();
        $page = isset($_GET['page']) ? $_GET['page'] : 1 ;//传入页面就使用page,没有就1
        $sql = "select count(*) as count from `order`";
        $sth = $this->db->link->prepare($sql);
        $sth->execute();
        $count = $sth->fetch(PDO::FETCH_ASSOC);
        $pageSize = 10;//每页的条数
        $start = ceil(($page-1)*$pageSize);
        include "./Framework/tool/PageTool.class.php";
        $PageHtml = PageTool::show("index.php?m=home&c=UserLibrary",$count['count'],$pageSize,$page);
        include_once "./Application/home/view/index/userLibrary.html";
    }
}