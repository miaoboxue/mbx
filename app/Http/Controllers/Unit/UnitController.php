<?php

namespace App\Http\Controllers\Unit;

use App\Model\NavModel;
use App\Model\UnitModel;
use App\Model\VkModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    //
    public function view(){
        $arr = VkModel::get();

        return view('unit.unit',['arr'=>$arr]);
    }

    public function all(){
//        var_dump($_POST);die;
        $unit_name=$_POST['unit_name'];
        $unit_text=$_POST['unit_text'];
        $vk_id=$_POST['vk_id'];
        $is_status=$_POST['is_status'];
        if (empty($unit_name)){
            return [
                'msg'=>'The name of the news bar cannot be empty',
                'status'=>5400
            ];
        }
        if (empty($unit_text)){
            return [
                'msg'=>'The name of the news bar cannot be empty',
                'status'=>5800
            ];
        }
        //验证唯一性
        $arr = UnitModel::where(['unit_name'=>$unit_name])->get()->toArray();
//        var_dump($arr);die;
        if(!empty($arr)){
            return [
                'msg'=>'The name of the news bar already exists',
                'status'=>'5500',
            ];
        }else{
            $data = [
                'unit_name'=>$unit_name,
                'unit_text'=>$unit_text,
                'vk_id'=>$vk_id,
                'is_status'=>$is_status,
                'is_del'=>0,
                'add_time'=>time(),
            ];
//            var_dump($data);die;
            $res =UnitModel::insert($data);
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
        $arr=UnitModel::get()->toArray();
//        var_dump($arr);die;
        return view('unit.list',['arr'=>$arr]);
    }
/*    public function table(){
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
        $unit_id=$_POST['unit_id'];
        if (empty($unit_id)){
            return [
                'msg'=>'error unit id ',
                'font'=>'请选择要删除的内容',
                'status'=>430,
            ];
        }
        $res = UnitModel::where(['unit_id'=>$unit_id])->update(['is_del'=>1]);
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
                'status'=>540,
                'font'=>'删除失败',
            ];
        }
    }


    public function update($unit_id){
        if (empty($unit_id)){
            return [
                'msg'=>'error unit id',
                'status'=>'455',
            ];
        }
        $arr = UnitModel::where(['unit_id'=>$unit_id])->first();
//        var_dump($arr);die;

        $info = VkModel::where(['vk_id'=>$arr['vk_id']])->get();
//        var_dump($info);die;
        return view('unit.update',['arr'=>$arr,'info'=>$info]);
    }

    public function updateall(){
        $unit_id=$_POST['unit_id'];
        if (empty($unit_id)){
            return [
                'msg'=>'error unit ',
                'status'=>630,
            ];
        }
        $unit_name=$_POST['unit_name'];
        $unit_text=$_POST['unit_text'];
        $vk_id=$_POST['vk_id'];
        $is_status=$_POST['is_status'];
        if (empty($unit_name)){
            return [
                'msg'=>'The name of the unit bar cannot be empty',
                'status'=>5400
            ];
        }
        if (empty($unit_text)){
            return [
                'msg'=>'The name of the unit bar cannot be empty',
                'status'=>5800
            ];
        }
        $data = [
            'unit_name'=>$unit_name,
            'unit_text'=>$unit_text,
            'vk_id'=>$vk_id,
            'is_status'=>$is_status,
            'add_time'=>time(),
        ];
//            var_dump($data);die;
        $res =UnitModel::where(['unit_id'=>$unit_id])->update($data);
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
    public function unitInfo($unit_name){
//        var_dump($unit_name);die;
        $arr = UnitModel::where(['unit_name'=>$unit_name])->first();
//        var_dump($arr);die;
        return view('unit.info',['arr'=>$arr]);
    }

}
