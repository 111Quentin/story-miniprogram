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

    // 通过页码获取数据
    public static function getStoryByPage($page=1, $size=20){
        $pagingData = self::where('is_hot','=',1)->order('created_time desc')
            ->paginate($size, true, ['page' => $page])->toArray();
        return $pagingData;
    }

}
