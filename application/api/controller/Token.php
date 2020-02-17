<?php



namespace app\api\controller;

use app\api\service\AppToken;
use app\api\service\UserToken;
use app\api\service\Token as TokenService;
use app\api\validate\AppTokenGet;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;

/**
 * 获取令牌，相等于登录
 */
class Token{

    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @POST code
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     */
    public function getToken($code='')
    {
        // (new TokenGet())->goCheck();
        $wx = new UserToken($code);
        $token = $wx->get();
        
        // return [
        //     'token' => $token
        // ];
        $data = array('token' => $token);
        return json($data);
    }


    /**
     * 第三方应用获取令牌
     * @url /app_token?
     * @POST ac=:ac se=:secret
     */
    public function getAppToken($ac='', $se=''){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET');
        (new AppTokenGet())->goCheck();
        $app = new AppToken();
        $token = $app->get($ac, $se);
        $data = array('token' => $token);
        // return [
        //     'token' => $token
        // ];
        return json($data);
    }


    public function verifyToken($token='')
    {
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
        $data = array('isValid' => $valid);
        // return [
        //     'isValid' => $valid
        // ];
        return json($data);
    }
}