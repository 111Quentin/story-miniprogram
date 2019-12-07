<?php

/**
 * 文章管理
 * 
 * @author: dayu
 * @version: 1.0
 */

namespace app\admin\controller;

use app\admin\common\Purview;
use app\admin\model\Story as MyModel;

class Story extends Purview
{

    /**
     * 列表页面
     * 
     * @return string
     */
    public function index()
    {

        $title = $this->request->get('title');
        $model = new MyModel();
        //下面这句是使用IN(1,2,...)的方式一次sql查询出分类名，不加的话是每条记录都发起一条sql查询分类名，当然in用不了索引的
        // $model = $model->withStoryCat();
        $query = [];
        if ($title)
        {
            $model = $model->where('title', 'like', '%'.$title.'%');
            $query = ['query' => ['title' => $title]];
        }
        $list = $model->order('id', 'desc')->paginate(10, false, $query);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('title', $title);
        $this->assign('page', $page);
        return $this->fetch();
    }

    /**
     * 执行批量删除
     * 
     * @return string
     */
    public function batchDel()
    {
        $idArray = $this->request->post('id');
        //至少要有一个选择对象
        if (isset($idArray[0]))
        {
            foreach ($idArray as $id)
            {
                $rs = $this->togetherDelete($id);
            }
            //   $rs = $model->where('id', 'in', $idArray)->delete();
            if ($rs)
            {
                return $this->success('操作成功', 'admin/Story/index');
            }
        }
        return $this->error('出错了，请选择要删除的对象');
    }

    /**
     * 执行删除
     * 
     * @return string
     */
    public function del()
    {
        $id = $this->request->param('id/d');


        if ($this->togetherDelete($id))
        {
            return $this->success('操作成功', 'admin/Story/index');
        }
        else
        {
            return $this->error('出错了，记录不存在');
        }
    }

    /**
     * 删除数据记录及图片什么的都一起打包删除
     * 
     * @access private
     * @param integer $id
     * @return bool
     */
    private function togetherDelete($id)
    {
        $model = MyModel::get($id);
        if ($model && $model->delete())
        {
            if ($model->pic)
            {
                $pic = '.' . $model->pic;
                if (file_exists($pic))
                {
                    unlink($pic);
                }
            }
            return true;
        }
        return false;
    }

    /**
     * 编辑页面
     * 
     * @return string
     */
    public function edit()
    {
        $id = $this->request->param('id/d');

        if ($id > 0)
        {
            $model = new MyModel();
            $records = $model->get($id);
            if ($records)
            {
                $this->assign('story', $records);
                $this->assign('StoryCat', $model->storyCat()->all());
                return $this->fetch();
            }
        }
        return $this->error('出错了', 'admin/Story/index');
    }

    /**
     * 执行编辑
     * 
     * @return string
     */
    public function doEdit()
    {
        $id = $this->request->param('id/d');
        if ($id > 0)
        {
            $data = $this->request->post('story');
            $data['updated_time'] = time();
            $story = new MyModel();
            $myStory = $story->get($id);
            if ($myStory)
            {
                //图片修改则删除旧图
                if ($myStory->pic != '' && $myStory->pic != $data['pic'])
                {
                    $oldPic = '.' . $myStory->pic;
                    if (file_exists($oldPic))
                    {
                        unlink($oldPic);
                    }
                }
                if ($myStory->save($data))
                {
                    return $this->success('操作成功', 'admin/Story/index');
                }
                else
                {
                    return $this->error($myStory->getError(), 'admin/Story/edit/id/' . $id);
                }
            }
        }
        return $this->error('操作失败，记录不存在');
    }

    /**
     * 新增页面
     * 
     * @return string
     */
    public function add()
    {
        $model = new MyModel();
        $this->assign('StoryCat', $model->storyCat()->all());
        return $this->fetch();
    }

    /**
     * 执行新增
     * 
     * @return string
     */
    public function doAdd()
    {
        $data = $this->request->post('story');
        $data['created_time'] = time();
        $data['updated_time'] = time();
        $myStory = new MyModel();
        if ($myStory->save($data))
        {
            return $this->success('操作成功', 'admin/Story/index');
        }
        else
        {
            return $this->error($myStory->getError(), 'admin/Story/add');
        }
    }

}
