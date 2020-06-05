<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/6/18
 * Time: 16:34
 */
include_once './Framework/tool/Model.php';
include './Application/admin/model/'.CONTROLLER_NAME.'Model.php';
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
//        $CourseModel = new CourseModel();
        $count = $this->model->count();
        $pageSize = 10;//每页的条数
        $start = ceil(($page-1)*$pageSize);
        include "./Framework/tool/PageTool.class.php";
        $PageHtml = PageTool::show("index.php?m=admin&c={$this->table_name}",$count['count'],$pageSize,$page);
        $rows = $this->model->getList($start,$pageSize);
        //实例话模型对象
        include_once "./Application/admin/view/{$this->table_name}/index.html";
    }
    public function save(){

        if($_POST){
            $result = $this->model->save($_POST);
                header("location:index.php?m=admin&c={$this->table_name}");exit;
        }
        $id = isset($_GET['id']) ? $_GET['id'] :'';
//        var_dump($id);die;
        if (!empty($id)){
            $row =  $this->model->select_one($id);
        }
        $course = $this->__data();
        //如果你是get请求则为访问添加页面
        include_once "./Application/admin/view/{$this->table_name}/save.html";
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
//            var_dump($result);die;
            header("location:index.php?m=admin&c={$this->table_name}");
        }
    }

//    public function excel($table_name = ''){
//
//        //引入我们的phpexcel第三方库,放导出excel中的数据
//        include_once './Framework/tool/PHPExcel/PHPExcel.php';
//        include_once './Framework/tool/PHPExcel/PHPExcel/IOFactory.php';
//        include_once './Framework/tool/PHPExcel/PHPExcel/Reader/Excel5.php';
//
//        //以上三步加载phpExcel的类
//        $objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
//        //我们上传的file的临时文件地址
//
//        $filename = $_FILES['judge']['tmp_name'];  //临时文件
//
//        $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
//        $sheet = $objPHPExcel->getSheet(0);
//
//        $sheetCount = $objPHPExcel->getSheetCount();  //读取sheet工作区域个数
//        $highestRow = $sheet->getHighestRow(); // 取得总行数55
//        $highestColumn = $sheet->getHighestColumn(); // 取得总列数
//        for ($i = 3; $i <= $highestRow; $i++) {
//            //循环列
//            for($colIndex='A';$colIndex<=$highestColumn;$colIndex++){
//                $cell = $objPHPExcel->getActiveSheet()->getCell($colIndex . $i)->getValue();
//                $data[$colIndex] = htmlspecialchars($cell);
//            }
//            if ($this->table_name == "Panduan"){
//                $time = time();
//                $sql = "insert into jav_panduan(title,sure_id,course_id,Yes,No,status,create_time) values('{$data['A']}','{$data['D']}',1,'{$data['B']}','{$data['C']}',1,{$time})";
//                $Model = new Model();
//                $result = $Model->db->link->exec($sql);
//                header("location:index.php?m=admin&c=Panduan");
//            } elseif($this->table_name == "Danxuan"){
//                $time = time();
//                $sql = "insert into jav_dan_xuan(title,sure_id,course_id,A,B,C,D,status,create_time) values('{$data['A']}','{$data['F']}','{$data['G']}','{$data['B']}','{$data['C']}','{$data['D']}','{$data['E']}',1,{$time})";
//                $Model = new Model();
//                $result = $Model->db->link->exec($sql);
//                header("location:index.php?m=admin&c=Danxuan");
//            }
//            elseif($this->table_name == "Duoxuan"){
//                $time = time();
//                $sql = "insert into jav_duo_xuan(title,sure_id,course_id,A,B,C,D,status,create_time) values('{$data['A']}','{$data['F']}','{$data['G']}','{$data['B']}','{$data['C']}','{$data['D']}','{$data['E']}',1,{$time})";
//                $Model = new Model();
//                $result = $Model->db->link->exec($sql);
//                header("location:index.php?m=admin&c=Duoxuan");
//            }elseif($this->table_name == "Wendati"){
//                $time = time();
//                $sql = "insert into jav_wendati(title,sure_id,course_id,status,create_time) values('{$data['A']}','{$data['B']}','{$data['C']}'1,{$time})";
//                $Model = new Model();
//                $result = $Model->db->link->exec($sql);
//                header("location:index.php?m=admin&c=Wendati");
//            }
//            //以上的for循环是循环出excel表中的数据
//
////var_dump($sql);die;
//
//        }
//
//    }


    public function Sen()
    {

        include_once "Application/admin/model/SenModel.php";
        $name = isset($_POST['name']) ? $_POST['name'] :'';
        $SenModel = new SenModel();
        $rows = $SenModel->index($name);
        include_once "Application/admin/view/sfs/index.html";
    }
}