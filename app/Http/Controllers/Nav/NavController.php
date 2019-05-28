<?php

namespace App\Http\Controllers\Nav;

use App\Model\NavModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavController extends Controller
{
    //导航栏试图
    public function nav(){
        return view('nav.navigation');
    }

    //导航栏添加
    public function navall(){
//        var_dump($_POST);die;
        $nav_name = $_POST['nav_name'];
        $status=$_POST['status'];
        $nav_url=$_POST['nav_url'];
//        var_dump($nav_name);
        //验证名称非空
        if (empty($nav_name)){
            return [
                'msg'=>'The name of the navigation bar cannot be empty',
                'status'=>5400
            ];
        }
        if (empty($nav_url)){
            return [
                'msg'=>'导航栏地址不能为空',
                'status'=>506,
            ];
        }
        if ($status == ""){
            return [
                'msg'=>'Please select state',
                'status'=>550,
            ];
        }
        //验证唯一性
        $arr = NavModel::where(['nav_name'=>$nav_name])->get()->toArray();
        if(!empty($arr)){
//            echo 111;die;
            return [
                'msg'=>'The name of the navigation bar already exists',
                'status'=>'5500',
            ];
        }else{
//            echo 222;die;
            $data = [
                'nav_name'=>$nav_name,
                'is_status'=>$status,
                'nav_url'=>$nav_url,
                'add_time'=>time()
            ];
            $res =NavModel::insert($data);
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
    }
    //导航栏列表
    public function list(){
        $arr=NavModel::get()->toArray();
        return view('nav.list',['arr'=>$arr]);
    }

    /*//列表数据
    public function table(){

//        var_dump($arr);
        foreach($arr as $v){
            if($v['is_status']==0){
                $v['is_status']='是';
            }else if($v['is_status']==1){
                $v['is_status']='否';
            }
            $v['add_time']=date('Y-m-d H:i:s');
        }
        return view('nav.list');
    }*/

    //删除
    public function delete(){
        $nav_id = $_POST['nav_id'];
        $res=NavModel::where(['nav_id'=>$nav_id])->delete();
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

    //修改
    public function update($nav_id){
        $arr=NavModel::where(['nav_id'=>$nav_id])->first();
//        var_dump($arr);die;
        return view('nav.update',['arr'=>$arr]);
    }

    //修改更新数据
    public function updateall(){
        $nav_name = $_POST['nav_name'];
        $status = $_POST['status'];
//        var_dump($_POST);die;
        $nav_id= $_POST['nav_id'];
        //验证名称非空
        if (empty($nav_name)){
            return [
                'msg'=>'The name of the navigation bar cannot be empty',
                'status'=>5400
            ];
        }
        if ($status == ""){
            return [
                'msg'=>'Please select state',
                'status'=>550,
            ];
        }
        $data = [
            'nav_name'=>$nav_name,
            'is_status'=>$status,
        ];
        $res =NavModel::where(['nav_id'=>$nav_id])->update($data);
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
//            var_dump($res);
    }
}
