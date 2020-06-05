<?php
/**
 * Created by PhpStorm.
 * User: biubi
 * Date: 2019/7/15
 * Time: 19:18
 */
include './Application/home/model/TeacherModel.php';
class AddTeacherController
{
    public function index(){
        $model = new TeacherModel();
        $data = $_POST;
        if (isset($data['from']) && $data['from'] == 'teacher'){
            if ($data['identify'] == '在校大学生'){
                if (isset($data['province'],$data['id_card'],$data['school'],$data['specialty'],$data['diploma'])){
                    if ($data['province'] == '' || $data['id_card'] == '' || $data['school'] == ''|| $data['specialty'] == ''|| $data['diploma'] == ''){
                        include_once "./Application/home/view/index/teacher_loser.html";exit;}
                }else{include_once "./Application/home/view/index/teacher_loser.html";exit;}
            }elseif ($data['identify'] == '在职老师'){
                if (isset($data['province'],$data['id_card'],$data['diploma'],$data['school'],$data['teach_subject'],$data['school_type'],$data['teach_age'],$data['rank'])){
                    if ($data['province'] == '' || $data['id_card'] == '' || $data['diploma'] == '' || $data['school'] == '' || $data['teach_subject'] == '' ||
                        $data['school_type'] == '' || $data['teach_age'] == '' || $data['rank'] == ''){
                        include_once "./Application/home/view/index/teacher_loser.html";exit;
                    }
                }else{include_once "./Application/home/view/index/teacher_loser.html";exit;}
            }elseif ($data['identify'] == '外籍人士'){
                if (isset($data['date'],$data['country'],$data['id_card'],$data['specialty'],$data['diploma'],$data['now_diploma'])){
                    if ($data['date'] == '' || $data['country'] == '' || $data['id_card'] == ''|| $data['specialty'] == ''|| $data['diploma'] == ''|| $data['now_diploma'] == ''){
                        include_once "./Application/home/view/index/teacher_loser.html";exit;}
                }else{include_once "./Application/home/view/index/teacher_loser.html";exit;}
            }elseif ($data['identify'] == '其他'){
                if (isset($data['province'],$data['id_card'],$data['school'],$data['specialty'],$data['now_diploma'])){
                    if ($data['province'] == '' || $data['id_card'] == '' || $data['school'] == ''|| $data['specialty'] == ''|| $data['now_diploma'] == ''){
                        include_once "./Application/home/view/index/teacher_loser.html";exit;}
                }else{include_once "./Application/home/view/index/teacher_loser.html";exit;}
            }else {include_once "./Application/home/view/index/teacher_loser.html";exit;}
            if (isset($data['name'],$data['sex'],$data['money'],$data['describe'],$data['time'],$data['phone'],$data['mail'],$data['address'],$data['subject'],$data['area'],
                $data['type'],$data['user'],$data['password'],$data['identify'])){
                if ($data['name'] == '' || $data['sex'] == '' || $data['money'] == '' || $data['describe'] == ''||  $data['time'] == ''
                    || $data['phone'] == ''|| $data['mail'] == '' || $data['address'] == ''|| $data['subject'] == '' || $data['area'] == '' || $data['type'] == ''
                    || $data['user'] == ''|| $data['password'] == '' || $data['identify'] == ''){
                    include_once "./Application/home/view/index/teacher_loser.html";exit;
                }
                $result = $model->save($data);
                if ($result){
                    include_once "./Application/home/view/index/teachersuccess.html";exit;
                }else{header("location:index.php?m=home&c=index");exit;}
            }else{include_once "./Application/home/view/index/teacher_loser.html";exit;}
        }
    }
}