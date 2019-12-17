<?php


namespace app\api\controller;

use app\admin\model\Story as StoryModel;
use app\lib\exception\MissException;
use app\api\validate\PagingParameter;
use app\lib\exception\SuccessMessage;



/**
 * Story资源
 */


class Story extends BaseController{

    /**
     * 按页获取热门推荐故事
     * @return void
     */
    public function getHotStory($page = 1,$size = 4){
        // 检查传递过来的参数
        (new PagingParameter())->goCheck();
        $Story_list = StoryModel::getHotStoryByPage($page,$size);
        if(!$Story_list){
            throw new MissException([
                'msg' => '请求story不存在',
                'errorCode' => 40000
            ]);
        }else{
            $this->show($Story_list);
        }
    }

    /**
     * 按页获取最新故事
     * @return void
     */
    public function getToptory($page = 1,$size = 4){
        // 检查传递过来的参数
        (new PagingParameter())->goCheck();
        $Story_list = StoryModel::getTopStoryByPage($page,$size);
        if(!$Story_list){
            throw new MissException([
                'msg' => '请求story不存在',
                'errorCode' => 40000
            ]);
        }else{
            $this->show($Story_list);
        }
    }
}