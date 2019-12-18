<?php


namespace app\api\controller;

use app\admin\model\StoryCat as StoryCatModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\MissException;

/**
 * StoryCat资源
 */

class StoryCat extends BaseController{

    /**
     * 获取所有的故事分类
     * @return void
     */
    public function getAllCategories(){
        $categories = StoryCatModel::where('sid','>',0)->order('created_time asc')->select()->toArray();
        if(!$categories){
            throw new MissException([
                'msg' => '还没有任何类目',
                'errorCode' => 50000
            ]);
        }else{
            $this->show($categories);
        }
    }

    /**
     * 获取单个故事数据
     * @param [type] $id
     * @return void
     */
    public function getCategory($id){
        // 检查传入元素
        $validate = new IDMustBePositiveInt();
        $validate->goCheck();
        $category = StoryCatModel::getCategory($id);
        // 使用抛出异常处理
        if(empty($category)){
            throw new MissException([
                'msg' => 'category not found'
            ]);
        }else{
            $this->show($category);
        }
    }
  
}