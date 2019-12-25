<?php

/**
 * Story模型
 * 
 * @author: dayu
 * @version: 1.0
 */

namespace app\admin\model;

use app\admin\common\ValidateModel;

class Story extends ValidateModel
{

    //验证规则
    public $_rules = [
        'title|故事标题' => 'required',
        'content|故事内容' => 'required',
        'story_cat_id|故事分类' => 'required|number',
        'is_hot' => 'default:0',
        'is_top' => 'default:0'
    ];
    //预设场景
    public $_scene = [
        'global' => [],
        'doEdit' => ['title', 'content', 'story_cat_id', 'is_hot', 'is_top'],
        'doAdd' => ['title', 'content', 'story_cat_id']
    ];

    public function storyCat()
    {
        return $this->belongsTo('StoryCat');
    }

    /**
     * 通过页码获取热门推荐数据
     * @param integer $page
     * @param integer $size
     * @return void
     */
    public static function getHotStoryByPage($page=1, $size=20){
        $pagingData = self::where('is_hot','=',1)->order('created_time desc')
            ->paginate($size, true, ['page' => $page])->toArray();
        $data = array();
        foreach($pagingData['data'] as $val){
            $val['created_time'] = date('Y-m-d',$val['created_time']);
            $val['updated_time'] = date('Y-m-d',$val['updated_time']);
            $data[] = $val;
        }
        $pagingData['data'] = $data;
        return $pagingData;
    }

    /**
     * 通过页码获取最新故事数据
     * @param integer $page
     * @param integer $size
     * @return void
     */
    public static function getTopStoryByPage($page=1, $size=20){
        $pagingData = self::where('is_top','=',1)->order('created_time desc')
            ->paginate($size, true, ['page' => $page])->toArray();
        $data = array();
        foreach($pagingData['data'] as $val){
            $val['created_time'] = date('Y-m-d',$val['created_time']);
            $val['updated_time'] = date('Y-m-d',$val['updated_time']);
            $data[] = $val;
        }
        $pagingData['data'] = $data;
        return $pagingData;
    }

    /**
     * 获取分类下的故事
     * @param [type] $categoryID
     * @param boolean $paginate
     * @param integer $page
     * @param integer $size
     * @return void
     */
    public static function getStoryByCategoryID($categoryID,$paginate = true,$page = 1,$size = 4){
        $query = self::where('story_cat_id',$categoryID);
        if(!$paginate){
            return $query->select();
        }else{
            // paginate 第二参数true表示采用简洁模式，简洁模式不需要查询记录总数
            return $query->paginate(
                $size, true, [
                'page' => $page
            ]); 
        }
    }

    /**
     * 获取单个故事
     * @param [type] $id
     * @return void
     */
    public static function getStoryDetail($id){
        $story = self::where('id',$id)->find();
        return $story ? $story : [];
    }

    /**
     * 获取上一篇故事和下一篇故事
     * @param [type] $id
     * @return void
     */
    public static function getPreNextStory($id){
        $PreNext_story = array();
        $pre_story = self::where('id','<',$id)->order('id desc')->find();
        $next_story = self::where('id','>',$id)->order('id asc')->find();
        $PreNext_story = array(
            'pre'   =>   $pre_story,
            'next'  =>   $next_story
        );
        return $PreNext_story ? $PreNext_story : [];
    }

}
