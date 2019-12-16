<?php

namespace app\api\behavior;
use think\Response;

class CORS
{
    public function run()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: *");
        header('Access-Control-Allow-Methods: *');
        header('Access-Control-Allow-Credentials:false');
        if(request()->isOptions()){
            sendResponse('',200,'ok');
        }
    }
}