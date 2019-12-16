<?php


namespace app\api\controller;

use app\admin\model\Carousel as CarouselModel;
use app\lib\exception\MissException;




/**
 * Banner资源
 */


class Banner extends BaseController{

    /**
     * 获取轮播图资源
     * @return void
     */
    public function getBanner(){
        $Banner_list = CarouselModel::where('id','>',0)->order('id','desc')->limit(3)->select()->toArray();
        if(!$Banner_list){
            throw new MissException([
                'msg' => '请求banner不存在',
                'errorCode' => 40000
            ]);
        }else{
            $this->show($Banner_list);
        }
    }
}