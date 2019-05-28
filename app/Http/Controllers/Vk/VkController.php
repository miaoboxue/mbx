<?php

namespace App\Http\Controllers\Vk;

use App\Model\VkModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VkController extends Controller
{
    //
    public function view(){
        return view('vk.vk');
    }
    public function all(){
        $vk_name = $_POST['vk_name'];
        $is_status=$_POST['is_status'];
//        var_dump($_POST);die;
        //验证名称非空
        if (empty($vk_name)){
            return [
                'msg'=>'The name of the news bar cannot be empty',
                'status'=>5400
            ];
        }

        //验证唯一性
        $arr = VkModel::where(['vk_name'=>$vk_name])->get()->toArray();
//        var_dump($arr);die;
        if(!empty($arr)){
            return [
                'msg'=>'The name of the news bar already exists',
                'status'=>'5500',
            ];
        }else{
            $data = [
                'vk_name'=>$vk_name,
                'is_status'=>$is_status,
                'add_time'=>time(),
            ];
            $res =VkModel::insert($data);
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
    public function list(){
        $arr=VkModel::get();

        return view('vk.list',['arr'=>$arr]);
    }

    /*//列表数据
    public function table(){
        foreach($arr as $v){
            if($v['is_status']==0){
                $v['is_status']='是';
            }else if($v['is_status']==1){
                $v['is_status']='否';
            }
            $v['add_time']=date('Y-m-d H:i:s');
        }
        return [
            'code'=>0,
            'data'=>$arr
        ];
    }*/

    public function delete(){
        $vk_id = $_POST['vk_id'];
        $res=VkModel::where(['vk_id'=>$vk_id])->delete();
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

    public function update($vk_id){
        $arr=VkModel::where(['vk_id'=>$vk_id])->first();

//        var_dump($arr);die;
        return view('vk.update',['arr'=>$arr]);
    }
    public function updateall(){
        $vk_name = $_POST['vk_name'];
        $vk_id=$_POST['vk_id'];
        $is_status = $_POST['is_status'];
        //验证名称非空
        if (empty($vk_name)){
            return [
                'msg'=>'The name of the news bar cannot be empty',
                'status'=>5400
            ];
        }
        $data = [
            'vk_name'=>$vk_name,
            'is_status'=>$is_status,
        ];
        $res =VkModel::where(['vk_id'=>$vk_id])->update($data);
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
}
