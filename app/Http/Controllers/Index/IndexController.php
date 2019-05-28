<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function login(){
      //  echo 11;
        $response = [
            'msg'=>'成功',
            'error'=>0
        ];
        return $response;
    }
    public function image(Request $request){
//        var_dump($request->post('content'));die;
//        echo '文件上传';
        /*$response = [
            'msg'=>'成功',
            'error'=>0
        ];
        return $response;*/
        //指定文件存储路径
        $file_save_path=app_path(). '/storage/uploads/' . date('Ym') .'/';
        if(!is_dir($file_save_path)){
            mkdir($file_save_path , 0777,true);
        }
//        var_dump($file_save_path);die;
        $file_name = time() . rand(1111,9999) . '.tmp';
//        var_dump($file_name);die;
        $byte=file_put_contents(
            $file_save_path . $file_name,
                base64_decode($request->post('content'))
        );
//        var_dump($byte);die;
        if($byte > 0){
            //查看文件格式
            $info = getimagesize($file_save_path . $file_name);
//            var_dump($info);die;
            if(!$info){
                return [
                    'status'=>6,
                    'data'=>[],
                    'msg'=>'图片格式内容或格式不正确'
                ];
            }

            //判断图片格式
            switch ($info['mime']){
                case 'image/jpg':
                    $new_file_name=str_replace('tmp','jpg',$file_name);
                    break;
                case 'image/jpeg':
                    $new_file_name=str_replace('tmp','jpg',$file_name);
                    break;
                case 'image/gif':
                    $new_file_name=str_replace('tmp','jpg',$file_name);
                    break;
                default;
            }
            //文件重新命名
            rename($file_save_path . $file_name,$file_save_path . $new_file_name);
//            var_dump($rename);die;
            $api_response =[];
            $access_path = str_replace(app_path() . '/storage' , '',$file_save_path);
//            var_dump($access_path);die;
            $api_response['access_path'] = env('FILE_UPLOAD_URL') . $access_path . $new_file_name;
//            var_dump($api_response);die;
            return [
                'status'=>1000,
                'msg' => 'success',
                'data'=>$api_response
            ];

        }
    }





}
