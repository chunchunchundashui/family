<?php
/**
 * Created by PhpStorm.
 * User: 春春春
 * Date: 2019/6/13
 * Time: 19:22
 */

class Upload
{
    //上传文件保存路径
    private $dir;
    //上传文件大小
    private $size;
    //上传文件错误信息
    private $cuowu;
    //上传文件类型
    private $type;
    //使用构造函数初始化属性
    public function __construct($dir='',$size='',$type='')
    {
        $this->dir = $dir;
        $this->size = $size;
        //将传入的字符串转成数组
        if (is_string($type)){
            $type = explode(',',$type);
        }
        $this->type = $type;
    }
    public function upload($file){
        //判断错误信息
        if ($file['error'] > 0){
            $this->cuowu = "上传文件失败";
        }
        //判断类型
        if (!in_array($file['type'],$this->type)){
            $this->cuowu = "上传文件类型不正确";
        }
        //判断文件大小
        if ($file['size']>$this->size){
            $this->cuowu = "上传文件大小为1024*1024";
        }
        //生成一个唯一的文件名
        $weiyi = uniqid(date('YmdHis').'_').strrchr($file['name'],'.');
        //生成上传图片保存的路径
        $dir = "./upload/$this->dir";
        if (!is_dir($dir)){  //如果地址不存在就添加，存在就不管
            mkdir($dir);
        }
        //指定上传路径
        $path = "./upload/$this->dir/$weiyi";
        if (move_uploaded_file($file['tmp_name'],$path)){
            return $path;
        }else{
            return false;
        }

    }
}