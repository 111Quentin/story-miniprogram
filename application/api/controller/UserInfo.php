<?php


namespace app\api\controller;

use app\api\model\UserInfo as UserInfoModel;
use app\lib\exception\MissException;



/**
 * UserInfo资源
 */


class Userinfo extends BaseController{

    /**
     * 将用户授权信息写入数据库
     */
    
     public function createUser(){
         $data = array();
         $data['nickname'] = $_REQUEST['nickname'];
         $data['gender'] = $_REQUEST['gender'];
         $data['country'] = $_REQUEST['country'];
         $data['province'] = $_REQUEST['province'];
         $data['city'] = $_REQUEST['city'];
         $data['avatarUrl'] = $_REQUEST['avatarUrl'];
         $data['create_time'] = time();

         // 判断是否入库
         $user = UserInfoModel::getUser($data['nickname']);
         if($user){
            $this->show($user,304,'用户数据已入库!');
         }else{
            // 数据入库
            $model = new UserInfoModel();
            $res = $model->save($data);
            if($res){
               $this->show($data,200,'用户数据保存成功！');
            }else{
               $this->show('',500,'用户数据保存失败');
            }
         }
         
        
     }
}