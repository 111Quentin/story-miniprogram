<?php

namespace app\api\model;


use app\lib\exception\TokenException;
use think\Exception;
use think\Model;


class User extends BaseModel{

    protected $autoWriteTimestamp = true;
    /**
     * 用户是否存在
     * 存在返回uid，不存在返回0
     */
    public static function getByOpenID($openid)
    {
        $user = User::where('openid', '=', $openid)
            ->find();
        return $user;
    }
}