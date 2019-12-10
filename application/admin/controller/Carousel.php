<?php

/**
 * 文章管理
 * 
 * @author: dayu
 * @version: 1.0
 */

namespace app\admin\controller;

use app\admin\common\Purview;
use app\admin\model\Carousel as MyModel;
use app\admin\model\Story;
class Carousel extends Purview
{

    /**
     * 列表页面
     * 
     * @return string
     */
    public function index()
    {

        $story_title = $this->request->get('story_title');
        $model = new MyModel();
        //下面这句是使用IN(1,2,...)的方式一次sql查询出分类名，不加的话是每条记录都发起一条sql查询分类名，当然in用不了索引的
        // $model = $model->withCarouselCat();
        $query = [];
        if ($story_title)
        {
            $model = $model->where('story_title', 'like', '%'.$story_title.'%');
            $query = ['query' => ['story_title' => $story_title]];
        }
        $list = $model->order('id', 'desc')->paginate(2, false, $query);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('story_title', $story_title);
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
                return $this->success('操作成功', 'admin/Carousel/index');
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
            return $this->success('操作成功', 'admin/Carousel/index');
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
                $this->assign('carousel', $records);
                $this->assign('story',$model->story()->all());
                return $this->fetch();
            }
        }
        return $this->error('出错了', 'admin/Carousel/index');
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
            $data = $this->request->post('carousel');
            $data['updated_time'] = time();
            $carousel = new MyModel();
            $myCarousel = $carousel->get($id);

            
            if ($myCarousel)
            {
                // 如果故事被修改了
                if($myCarousel->pic != '' && $myCarousel->story_id != $data['story_id']){
                    // 修改对应的故事title
                    $story = Story::where('id','=',$data['story_id'])->column('title');
                    $data['story_title'] = $story[0];
                }

                //图片修改则删除旧图
                if ($myCarousel->pic != '' && $myCarousel->pic != $data['pic'])
                {
                    $oldPic = '.' . $myCarousel->pic;
                    if (file_exists($oldPic))
                    {
                        unlink($oldPic);
                    }
                }

                if ($myCarousel->save($data))
                {
                    return $this->success('操作成功', 'admin/Carousel/index');
                }
                else
                {
                    // 修改数据失败，也删除对应的图片和文件
                    if(!$data['pic']){
                        $nowPic = '.' . $data['pic'];
                        if(file_exists($nowPic)){
                            unlink($nowPic);
                        }
                    }
                    return $this->error($myCarousel->getError(), 'admin/Carousel/edit/id/' . $id);
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
        $this->assign('Story', $model->story()->all());
        return $this->fetch();
    }

    /**
     * 执行新增
     * 
     * @return string
     */
    public function doAdd()
    {
        $data = $this->request->post('carousel');
        // 插入对应的故事title
        $story = Story::where('id','=',$data['story_id'])->column('title');
        $data['story_title'] = $story[0];
        $data['created_time'] = time();
        $data['updated_time'] = time();
        $myCarousel = new MyModel();
        if ($myCarousel->save($data))
        {
            return $this->success('操作成功', 'admin/Carousel/index');
        }
        else
        {   
            // 修改数据失败，也删除对应的图片和文件
            if(!$data['pic']){
                $nowPic = '.' . $data['pic'];
                if(file_exists($nowPic)){
                    unlink($nowPic);
                }
            }
            return $this->error($myCarousel->getError(), 'admin/Carousel/add');
        }
    }

}
