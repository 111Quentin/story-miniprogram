<?php

namespace app\api\controller;
use think\Controller;
use think\Exception;
class BaseController extends Controller{
    
    /**
     * 公用接口返回方法
     * @param [type] $data
     * @param integer $code
     * @param string $msg
     * @return void
     */
    protected function show($data,$code=200,$msg='获取数据成功'){
        $res = array(
            'code' => $code,
            'msg'  => $msg,
            'data'  => $data
        );
        if(!$data){
            $res['code'] = '404';
            $res['msg'] = '获取数据有误!';
            echo json_encode($res);
            exit;
        }else{
            echo json_encode($res);
            exit;
        }
    }
} 