<?php

/**
 * 文章管理
 * 
 * @author: dayu
 * @version: 1.0
 */

namespace app\admin\controller;

use app\admin\common\Purview;
use app\api\model\UserInfo as UserInfoModel;

class UserInfo extends Purview
{

    /**
     * 列表页面
     * 
     * @return string
     */
    public function index()
    {

        $nickName = $this->request->get('nickName');
        $model = new UserInfoModel();
       
        $query = [];
        if ($nickName)
        {
            $model = $model->where('nickName', 'like', '%'.$nickName.'%');
            $query = ['query' => ['nickName' => $nickName]];
        }
        $userinfo = $model->order('id', 'desc')->paginate(5, false, $query);
        $page = $userinfo->render();
        $this->assign('userinfo', $userinfo);
        $this->assign('nickName', $nickName);
        $this->assign('page', $page);
        return $this->fetch();
    }


}
