<?php


namespace app\api\controller;

use app\admin\model\StoryCat as StoryCatModel;
use app\lib\exception\MissException;





/**
 * StoryCat资源
 */


class StoryCat extends BaseController{

    /**
     * 按页获取热门推荐故事
     * @return void
     */
    public function getAllCategories(){
        $categories = StoryCatModel::all([]);
        if(!$categories){
            throw new MissException([
                'msg' => '还没有任何类目',
                'errorCode' => 50000
            ]);
        }else{
            $this->show($categories);
        }
    }

  
}