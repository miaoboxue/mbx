<?php

namespace App\Http\Controllers\Img;

use App\Model\ImgModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
class ImgController extends Controller
{
    //
    public function view(){
        return view('img.img');
    }

    public function imgAll(){
        $type=$_GET['type'];
        $d=$type==1?'goodsimg':'goodsimgs';
        // var_dump($d);die;
        $this->upload($d);
    }
    public function upload($d){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');

        // print_r($file);die;
        // 移动到框架应用根目录/public/uploads/ 目录下
        $path = $file->getRealPath();
        $ext = $file->getClientOriginalExtension();
        // var_dump($ext);die;
        //定义文件名
        $filename = date('Y-m-d-H-i-s').'.'.$ext;
//        var_dump($filename);die;
        //存储文件。disk里面的public。总的来说，就是调用disk模块里的public配
        $url= '/uploads/'.$filename;

        $info=Storage::disk('public')->put($filename, file_get_contents($path));
//         var_dump($info);die;
        if($info) {
            $arr = [
                'code' => 1,
                'font' => '上传成功',
                'url'=>$url
                //'src'=>$info->getSaveName()
            ];
            echo json_encode($arr);
        }
    }
    public function imgData(){
        $img = $_POST['image'];
        if (empty($img)){
            return [
                'msg'=>'请上传一张图片',
                'status'=>640,
            ];
        }
        $is_status=$_POST['is_status'];

        $data=[
            'image'=>$img,
            'is_status'=>$is_status,
            'add_time'=>time(),
        ];
//        var_dump($data);die;
        $arr=ImgModel::insert($data);
        if ($arr){
            return [
                'msg'=>'添加成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'添加失败',
                'status'=>730,
            ];
        }
    }
    public function list(){
        return view('img.list');
    }
    public function table(){
        $arr = ImgModel::get();
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
            $v['image']=".<img src='".$v['image']."'>.";
        }
        return [
            'code'=>0,
            'data'=>$arr
        ];
    }

    public function delete(){
        $id= $_POST['id'];
        $res = ImgModel::where(['id'=>$id])->update(['is_del'=>1]);
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
}
