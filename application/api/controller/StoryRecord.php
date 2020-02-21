<?php


namespace app\api\controller;

use app\api\model\StoryRecord as StoryRecordModel;
use app\lib\exception\MissException;
use app\api\validate\IDMustBePositiveInt;


/**
 * StoryRecord资源
 */


class StoryRecord extends BaseController{

    /**
     * 将用户授权信息写入数据库
     */
    
     public function createRecord(){
         $data = array();
         $data['uid'] = $_REQUEST['uid'];
         $data['sid'] = $_REQUEST['sid'];
         $data['title'] = $_REQUEST['title'];
         $data['create_time'] = date('Y-m-d H:i:s',time());;

         // 数据入库
         $record = new StoryRecordModel();
         $res = $record->save($data);
         if($res){
            $this->show($data,200,'保存成功！');
         }else{
            $this->show('',500,'保存失败');
         }
     }

     /**
      * 查找用户的播放记录
      */
     public function select($id){
         (new IDMustBePositiveInt())->goCheck();
         $records = StoryRecordModel::getRecord($id);
         //   var_dump($records);
         $this->show($records,200,'获取数据成功!');
     }

}