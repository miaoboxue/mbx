<?php

namespace App\Http\Controllers\News;

use App\Model\NavModel;
use App\Model\NewOneModel;
use App\Model\NewsModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    //

    //分类添加试图
    public function view(){
        $arr=NavModel::get();
        return view('news.news',['arr'=>$arr]);
    }
    public function all(){
        $news_name = $_POST['news_name'];
        $is_status = $_POST['is_status'];
        $nav_id=$_POST['nav_id'];
//        var_dump($_POST);die;
        //验证名称非空
        if (empty($news_name)){
            return [
                'msg'=>'The name of the news bar cannot be empty',
                'status'=>5400
            ];
        }

            $data = [
                'news_name'=>$news_name,
                'nav_id'=>$nav_id,
                'is_status'=>$is_status,
                'add_time'=>time(),
                'up_time'=>time(),
            ];
            $res =NewsModel::insert($data);
            if ($res){
                return [
                    'msg'=>'添加成功',
                    'status'=>200,
                ];
            }else{
                return [
                    'msg'=>'添加失败',
                    'status'=>'5600'
                ];
            }
//            var_dump($res);
    }
    public function list(){
        $arr=NewsModel::get()->toArray();
//        var_dump($arr);die;
        return view('news.list',['arr'=>$arr]);
    }
/*    //列表数据
    public function table(){


        foreach($arr as $v){
            if($v['is_status']==0){
                $v['is_status']='是';
            }else if($v['is_status']==1){
                $v['is_status']='否';
            }
            if($v['is_del']==1){
                $v['is_del']='是';
            }else if($v['is_del']==0){
                $v['is_del']='否';
            }
            $v['add_time']=date('Y-m-d H:i:s');
            $v['up_time']=date('Y-m-d H:i:s');
        }
        return [
            'code'=>0,
            'data'=>$arr
        ];
    }*/
    //删除
    public function delete(){
        $news_id = $_POST['news_id'];

        $res=NewsModel::where(['news_id'=>$news_id])->update(['is_del'=>1]);
        if($res){
            return [
                'msg'=>'success',
                'status'=>200,
                'font'=>'删除成功',
                'code'=>1,
            ];
        }else{
            return [
                'msg'=>'error',
                'status'=>5400,
                'font'=>'删除失败',
            ];
        }
    }
    public function update($news_id){
        $arr=NewsModel::where(['news_id'=>$news_id])->first();
        $info=NavModel::get();

//        var_dump($arr);die;
        return view('news.update',['arr'=>$arr,'info'=>$info]);
    }
    public function updateall(){
        $news_name = $_POST['news_name'];
        $nav_id=$_POST['nav_id'];
        $news_id = $_POST['news_id'];
        //验证名称非空
        if (empty($news_name)){
            echo 111;
            return [
                'msg'=>'The name of the news bar cannot be empty',
                'status'=>5400
            ];
        }
        $data = [
            'news_name'=>$news_name,
            'nav_id'=>$nav_id,
            'up_time'=>time()
        ];
        $res =NewsModel::where(['news_id'=>$news_id])->update($data);
        if ($res){
            return [
                'msg'=>'修改成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'修改失败',
                'status'=>'5600'
            ];
        }
    }


    public function newsView(){
        $arr = NewsModel::get()->toArray();
        return view('newsView.view',['arr'=>$arr]);
    }
    public function newsAdd(){
//        var_dump($_POST);die;
        $new_name=$_POST['new_name'];
        if (empty($new_name)){
            return [
                'msg'=>'新闻标题不能为空',
                'status'=>540,
            ];
        }
        $new_text=$_POST['new_text'];
        if (empty($new_text)){
            return [
                'msg'=>'新闻内容不能为空',
                'status'=>550,
            ];
        }
        $is_status=$_POST['is_status'];
        $news_id=$_POST['news_id'];
        if (empty($news_id)){
            return [
                'msg'=>'请选择新闻类型',
                'status'=>560,
            ];
        }
        $data=[
            'new_name'=>$new_name,
            'new_text'=>$new_text,
            'is_status'=>$is_status,

            'news_id'=>$news_id,
            'add_time'=>time()
        ];
//        var_dump($data);die;
        $res = NewOneModel::insert($data);
        if ($res){
            return [
                'msg'=>'添加成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'添加失败',
                'status'=>570,
            ];
        }
    }

    public function newsList(){
        $arr = NewOneModel::get();
        return view('newsView.list',['arr'=>$arr]);
    }
 /*   public function newsTable(){


        foreach($arr as $v){
            if($v['is_status']==0){
                $v['is_status']='是';
            }else if($v['is_status']==1){
                $v['is_status']='否';
            }
            if($v['is_del']==1){
                $v['is_del']='是';
            }else if($v['is_del']==0){
                $v['is_del']='否';
            }
            $v['add_time']=date('Y-m-d H:i:s');
        }
        return [
            'code'=>0,
            'data'=>$arr
        ];
    }*/
    public function newsDelete(){
        $new_id=$_POST['new_id'];
        $res = NewOneModel::where(['new_id'=>$new_id])->update(['is_del'=>1]);
        if($res){
            return [
                'msg'=>'success',
                'status'=>200,
                'font'=>'删除成功',
                'code'=>1,
            ];
        }else{
            return [
                'msg'=>'error',
                'status'=>5400,
                'font'=>'删除失败',
            ];
        }
    }

    public function newsUpdate($new_id){
        $arr = NewOneModel::where(['new_id'=>$new_id])->first();
        $info = NewsModel::get();

        return view('newsView.update',['arr'=>$arr,'info'=>$info]);
    }
    public function newsUp(){
//        var_dump($_POST);die;
        $new_name = $_POST['new_name'];
        if (empty($new_name)){
            return [
                'msg'=>'新闻标题不能为空',
                'status'=>540,
            ];
        }
        $new_text=$_POST['new_text'];
        if (empty($new_text)){
            return [
                'msg'=>'新闻内容不能为空',
                'status'=>550,
            ];
        }
        $is_status=$_POST['is_status'];
        $news_id=$_POST['news_id'];
        if (empty($news_id)){
            return [
                'msg'=>'请选择新闻类型',
                'status'=>560,
            ];
        }
        $new_id=$_POST['new_id'];
        if (empty($new_id)){
            return [
                'msg'=>'请选择修改的新闻',
                'status'=>'580',
            ];
        }
        $data=[
            'new_name'=>$new_name,
            'new_text'=>$new_text,
            'is_status'=>$is_status,
            'news_id'=>$news_id,
        ];
//        var_dump($data);die;
        $res = NewOneModel::where(['new_id'=>$new_id])->update($data);
        if ($res){
            return [
                'msg'=>'修改成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'修改失败',
                'status'=>570,
            ];
        }
    }
    public function newInfo($new_name){
//        var_dump($new_name);die;
        $arr = NewOneModel::where(['new_name'=>$new_name])->first();
        return view('newsView.info',['arr'=>$arr]);
    }
}
