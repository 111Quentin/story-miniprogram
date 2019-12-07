<?php

/**
 * GoodsImages模型
 * 
 * @author: dayu
 * @version: 1.0
 */

namespace app\admin\model;

use app\admin\common\ValidateModel;

class GoodsImages extends ValidateModel
{

    public function goods()
    {
        return $this->belongsTo('Goods');
    }

}
