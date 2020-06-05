<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/6/18
 * Time: 16:34
 */
include './Application/home/model/'.CONTROLLER_NAME.'Model.php';
class BaseController
{
    protected $table_name = '';
    public $model;
    //构造函数，直接创建类对象
    public function __construct()
    {
        $Model = $this->table_name.'Model';
        $this->model = new $Model();
    }
    public function index(){
        $page = isset($_GET['page']) ? $_GET['page'] : 1 ;//传入页面就使用page,没有就1
        $count = $this->model->count();
        $pageSize = 12;//每页的条数
        $start = ceil(($page-1)*$pageSize);
        include "./Framework/tool/PageTool.class.php";
        $PageHtml = PageTool::show("index.php?m=home&c={$this->table_name}",$count['count'],$pageSize,$page);
        $rows = $this->model->getList($start,$pageSize);
        //实例话模型对象
        include_once "./Application/home/view/index/{$this->table_name}Library.html";
    }
    public function save(){
        if($_POST){
            $result = $this->model->save($_POST);
            if ($result){
                include_once "./Application/home/view/index/{$this->table_name}success.html";exit;
            }
            header("location:index.php?m=home&c=index");exit;
        }
        $id = isset($_GET['id']) ? $_GET['id'] :'';
        if (!empty($id)){
            $row =  $this->model->select_one($id);
        }
        $course = $this->__data();
        //如果你是get请求则为访问添加页面
        include_once "./Application/home/view/{$this->table_name}/save.html";
    }
    /*
     * 创建一个钩子方法，用于子类继承,在我们显示页面之前查询出所需要的数据
     */
    protected function __data(){

    }
    public function del(){
//        $CourseModel = new CourseModel();
        $id = isset($_GET['id']) ? $_GET['id'] :'';
        if (!empty($id)){
            $result =  $this->model->del_to($id);
            header("location:index.php?m=home&c={$this->table_name}");
        }
    }
}