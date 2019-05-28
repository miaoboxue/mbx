<?php

namespace App\Http\Controllers\Vcode;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VcodeController extends Controller
{
    //
    public function vcode(){
        session_start();
        $sid= session_id();
        $url='http://vm.laravel.com/showVcode/' .$sid;
        $data=[
            'sid'=>$sid,
            'url'=>$url
        ];
        echo json_encode($data);

    }
    /*
     * 展示图片验证码*/
    public function showVcode(Request $request,$sid = ''){
//        echo 111;die;
        session_id($sid);
        session_start();

        $a=rand(1,9);
        $b=rand(1,9);
        $rand = $a.'+'.$b.'=?';
//        echo $rand;die;
//        $rand =rand(1111,9999);
        $_SESSION=[
            'vcode'=>$a+$b,
        ];

        header('content-type:image/png');


        //创建一个画布
        $im= imagecreatetruecolor(150,60);
        //创建几个颜色
        $wieth = imagecolorallocate($im,255,255,255);

        $black = imagecolorallocate($im,0,0,0);

        //填充画布背景颜色
        imagefilledrectangle($im,0,0,399,60,$wieth);
        //字体文件
        $font = "/www/laravel/public/a.ttf";
        $len =strlen($rand);
        $i = 0;
        while ($i<$len){
            imagettftext($im, 20, rand(-10,10), 30*$i, 40, $black, $font, $rand[$i]);
            $i++;
        }
        imagepng($im);
        imagedestroy($im);
        exit();
    }
    public function checkShow(Request $request){
        $sid=$request->post('sid');
        $vcode = $request->post('vcode');
//        var_dump($vcode);die;
//        var_dump($request->post());die;
        session_id($sid);
        session_start();
        $code = $_SESSION['vcode'];
//        var_dump($_SESSION['vcode']);die;
        if($code == $vcode){
            return[
                'status'=>1000,
                'msg'=>'success',
            ];
        }else{
            return[
                'status'=>10,
                'msg'=>'error',
                'data'=>[]
            ];
        }
    }
}
