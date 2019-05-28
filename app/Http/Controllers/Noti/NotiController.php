<?php

namespace App\Http\Controllers\Noti;

use App\Model\NewOneModel;
use App\Model\NotiModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotiController extends Controller
{
    //
    public function view(){
        $arr = NewOneModel::where(['is_status'=>0])->get();
        return view('noti.view',['arr'=>$arr]);
    }
    public function all(){
//        var_dump($_POST);die;
        $noti_name = $_POST['noti_name'];
        if (empty($noti_name)){
            return [
                'msg'=>'通知公告',
                'status'=>505,
            ];
        }
        $noti_url = $_POST['noti_url'];
        if (empty($noti_url)){
            return [
                'msg'=>'公告地址不能为空',
                'status'=>506,
            ];
        }
        $is_status=$_POST['is_status'];
        $new_id = $_POST['new_id'];
        $data = [
            'noti_name'=>$noti_name,
            'noti_url'=>$noti_url,
            'new_id'=>$new_id,
            'is_status'=>$is_status,
            'is_del'=>0,
            'add_time'=>time(),
        ];
        $res = NotiModel::insert($data);
        if ($res){
            return [
                'msg'=>'添加成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'添加失败',
                'status'=>507
            ];
        }
    }
    public function list(){
        $arr = NotiModel::get()->toArray();
        return view( 'noti.list',['arr'=>$arr]);
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
        $noti_id=$_POST['noti_id'];

        $res = NotiModel::where(['noti_id'=>$noti_id])->update(['is_del'=>1]);
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
    public function update($noti_id){
        $arr = NotiModel::where(['noti_id'=>$noti_id])->first();
        $info = NewOneModel::where(['is_status'=>0])->get();

        return view('noti.update',['arr'=>$arr,'info'=>$info]);
    }
    public function upAll(){
//        var_dump($_POST);die;
        $noti_id = $_POST['noti_id'];
        if (empty($noti_id)){
            return [
                'msg'=>'请选择要修改的内容',
                'status'=>508,
            ];
        }
        $noti_name = $_POST['noti_name'];
        if (empty($noti_name)){
            return [
                'msg'=>'通知公告不能为空',
                'status'=>505,
            ];
        }
        $noti_url = $_POST['noti_url'];
        if (empty($noti_url)){
            return [
                'msg'=>'公告地址不能为空',
                'status'=>506,
            ];
        }
        $is_status=$_POST['is_status'];
        $new_id = $_POST['new_id'];
        $data = [
            'noti_name'=>$noti_name,
            'noti_url'=>$noti_url,
            'new_id'=>$new_id,
            'is_status'=>$is_status,
        ];
//        var_dump($data);die;
        $res = NotiModel::where(['noti_id'=>$noti_id])->update($data);
        if ($res){
            return [
                'msg'=>'修改成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'修改失败',
                'status'=>507
            ];
        }
    }
}
