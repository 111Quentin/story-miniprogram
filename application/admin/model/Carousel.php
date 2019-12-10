<?php

/**
 * Carousel模型
 * 
 * @author: dayu
 * @version: 1.0
 */

namespace app\admin\model;

use app\admin\common\ValidateModel;

class Carousel extends ValidateModel
{

    //验证规则
    public $_rules = [
        'pic|轮播图' => 'required',
    ];
    //预设场景
    public $_scene = [
        'global' => [],
        'doEdit' => ['pic','story_id','story_name'],
        'doAdd' => ['pic','story_id','story_name']
    ];

    // 与故事模型建立一对一关联
    public function story(){
        return $this->belongsTo('Story');
    }
}
