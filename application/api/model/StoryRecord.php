<?php

namespace app\api\model;


use think\Exception;
// use think\Model;


class storyRecord extends BaseModel{

    // 获取用户的浏览记录
    public static function getRecord($uid){
        $records = self::where('uid',$uid)->select();
        return $records ? $records : [];
    }
}