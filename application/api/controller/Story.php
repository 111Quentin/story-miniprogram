<?php


namespace app\api\controller;

use app\admin\model\Story as StoryModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\MissException;
use app\api\validate\PagingParameter;
use app\lib\exception\ParameterException;
use app\lib\exception\StoryException;


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


    /**
     * 获取分类下所有故事 
     * @param integer $id
     * @param integer $page
     * @param integer $size
     * @return void
     */
    public function getByCategory($id = -1,$page = 1,$size = 4){
        (new IDMustBePositiveInt())->goCheck();
        (new PagingParameter())->goCheck();
        $CateStory = StoryModel::getStoryByCategoryID($id,true,$page,$size);
        if($CateStory->isEmpty()){
            // 对于分页最好不要抛出MissException，客户端并不好处理
            return [
                'current_page' => $CateStory->currentPage(),
                'data' => []
            ];
        }else{
            $data = $CateStory->toArray();
            $this->show($data);
        }
    }

    /**
     * 获取单个故事
     * @param [type] $id
     * @return void
     */
    public function getOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $story = StoryModel::getStoryDetail($id);
        // 使用抛出异常处理
         if(empty($story)){
            throw new MissException([
                'msg' => 'story not found'
            ]);
        }else{
            $this->show($story);
        }
    }


    /**
     * 获取上一篇和下一篇故事
     * @param [type] $id
     * @return void
     */
    public function getPreNext($id){
        // id校验
        (new IDMustBePositiveInt())->goCheck();
        $PreNext_story = StoryModel::getPreNextStory($id);
        // 使用抛出异常处理
        if(empty($PreNext_story)){
            throw new MissException([
                'msg' => 'story not found'
            ]);
        }else{
            $this->show($PreNext_story);
        }
    }

    /**
     * 根据故事标题查询故事
     */
    public function getByTitle($title){
        $story = StoryModel::where('title','like','%' . $title . '%')->select()->toArray();
        $this->show($story);
    }
}