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

    // 通过页码获取热门推荐数据
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

    // 通过页码获取最新故事数据
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

}
