<?php

namespace App\Http\Controllers\Link;

use App\Model\LinkModel;
use Encore\Admin\Grid\Displayers\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinkController extends Controller
{
    //
    public function view(){
        return view('link.view');
    }
    public function add(){
        $link_name = $_POST['link_name'];
        if (empty($link_name)){
            return [
                'msg'=>'相关连接名称不能为空',
                'status'=>503,
            ];
        }
        $link_url=$_POST['link_url'];
        if (empty($link_url)){
            return [
                'msg'=>'连接地址不能为空',
                'status'=>'507',
            ];
        }
        $is_status = $_POST['is_status'];
        if ($is_status == ''){
            return [
                'msg'=>'请选择是否展示',
                'status'=>505,
            ];
        }
        $data = [
            'link_name'=>$link_name,
            'is_status'=>$is_status,
            'link_url'=>$link_url,
            'add_time'=>time()
        ];
//        var_dump($data);die;
        $res = LinkModel::insert($data);
        if ($res){
            return [
                'msg'=>'添加成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'添加失败',
                'status'=>506,
            ];
        }
    }
    public function list(){
        $arr = LinkModel::get();

        return view('link.list',['arr'=>$arr]);
    }

    /*public function table(){

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
    public function delete(){
        $link_id=$_POST['link_id'];
//        var_dump($link_id);die;
//        var_dump($res);die;
        $res = LinkModel::where(['link_id'=>$link_id])->update(['is_del'=>1]);
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
    public function update($link_id){
        $arr = LinkModel::where(['link_id'=>$link_id])->first();

        return view('link.update',['arr'=>$arr]);
    }
    public function upadd(){
        $link_name = $_POST['link_name'];
        $link_id = $_POST['link_id'];
        if (empty($link_id)){
            return [
                'msg'=>'请选择要修改的连接',
                'status'=>509,
            ];
        }
        if (empty($link_name)){
            return [
                'msg'=>'相关连接名称不能为空',
                'status'=>503,
            ];
        }
        $link_url=$_POST['link_url'];
        if (empty($link_url)){
            return [
                'msg'=>'连接地址不能为空',
                'status'=>'507',
            ];
        }
        $is_status = $_POST['is_status'];
        if ($is_status == ''){
            return [
                'msg'=>'请选择是否展示',
                'status'=>505,
            ];
        }
        $data = [
            'link_name'=>$link_name,
            'is_status'=>$is_status,
            'link_url'=>$link_url,
        ];
//        var_dump($data);die;
        $res = LinkModel::where(['link_id'=>$link_id])->update($data);
        if ($res){
            return [
                'msg'=>'修改成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'修改失败',
                'status'=>506,
            ];
        }
    }
}
