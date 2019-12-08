<?php
/**
 * 文章分类管理
 * 
 * @author: dayu
 * @version: 1.0
 */
namespace app\admin\controller;

use app\admin\common\Purview;
use app\admin\model\StoryCat as MyModel;


class StoryCat extends Purview
{
    /**
     * 列表页面
     * 
     * @return string
     */
    public function index()
    {
        $type_name = $this->request->get('type_name');
        $model = new MyModel();
        // 根据分类名进行检索
        $query = [];
        if($type_name){
            $model = $model->where('type_name','like','%'.$type_name.'%');
            $query = ['query' => ['type_name' => $type_name]];
        }
        $list = $model->order('sid', 'desc')->paginate(5, false, $query);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('type_name', $type_name);
        $this->assign('page', $page);
        return $this->fetch();
    }
    /**
     * 执行删除
     * 
     * @return string
     */
    public function del()
    {
        $id = $this->request->param('id/d');

        if ($id > 0)
        {
            //together注意是大小写,因为get里面取到的数组索引被转成小写了
            if ($this->togetherDelete($id))
            {
                return $this->success('操作成功');
            }
        }
        return $this->error('出错了,记录不存在');
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
                return $this->success('操作成功', 'admin/StoryCat/index');
            }
        }
        return $this->error('出错了，请选择要删除的对象');
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
                $this->assign('records', $records);
                return $this->fetch();
            }
        }
        return $this->error('出错了，记录不存在');
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
            $data = $this->request->post('StoryCat');
            $model = new MyModel();
            $myModel = $model->get($id);
            if ($myModel)
            {
                // 图片修改则删除旧图
                if ($myModel->pic != '' && $myModel->pic != $data['pic'])
                {
                    $oldPic = '.' . $myModel->pic;
                    if (file_exists($oldPic))
                    {
                        unlink($oldPic);
                    }
                }
                $data['updated_time'] = time();
                $rs = $myModel->save($data);
                if (1 == $rs)
                {
                    return $this->success('操作成功', '/admin/StoryCat/index');
                }
                else
                {
                    return $this->error($myModel->getError(), '/admin/StoryCat/edit/id/' . $id);
                }
            }
        }
        $nowPic = '.' . $data['pic'];
        if(file_exists($nowPic)){
            unlink($nowPic);
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
        return $this->fetch();
    }
    /**
     * 执行新增
     * 
     * @return string
     */
    public function doAdd()
    {
        $data = $this->request->post('StoryCat');
        $data['created_time'] = time();
        $data['updated_time'] = time();
        $model = new MyModel();
        if ($model->save($data))
        {
            return $this->success('操作成功', '/admin/StoryCat/index');
        }
        else
        {
            return $this->error($model->getError(), '/admin/StoryCat/add');
        }
    }

    /**
     * 删除故事分类以及该分类下的所有故事，以及硬盘上的所有文件
     * 
     * @access private
     * @param integer $id
     * @return bool
     */
    private function togetherDelete($id){
        $model = MyModel::get($id, 'Story');
        if ($model && $model->together('story')->delete()){
                if($model->pic){
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

}
