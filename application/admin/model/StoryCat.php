<?php

/**
 * StoryCat模型
 * 
 * @author: dayu
 * @version: 1.0
 */

namespace app\admin\model;

use app\admin\common\ValidateModel;

class StoryCat extends ValidateModel
{

    protected $pk = 'sid';
    //验证规则
    public $_rules = [
        'type_name|分类名' => 'required'
    ];
    //预设场景
    public $_scene = [
        'global' => [],
        'doEdit' => ['type_name'],
        'doAdd' => ['type_name']
    ];

    public function story()
    {
        return $this->hasMany('Story');
    }

}
