<?php

namespace app\api\model;


use think\Exception;
// use think\Model;


class UserInfo extends BaseModel{

    /**
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getUser($nickname)
    {
        $user = UserInfo::where('nickname', '=', $nickname)
            ->find();
        return $user;
    }
}