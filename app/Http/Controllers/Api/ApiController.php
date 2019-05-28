<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\ApiModel;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //
    public function type(){
//        var_dump($_POST);
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $type = $_POST['type'];

        $userInfo=ApiModel::where(['email'=>$email,'password'=>$pwd])->first();
        if($type == 'Android'){
            echo 'Android';
            $this -> Android($userInfo);
        }elseif ($type == 'pc'){
            echo 'pc';
            $this -> pc($userInfo);
        }else{
            echo 'ios';
            $this -> ios($userInfo);
        }
    }
    //安卓登录 存入Redis
    public function Android($userInfo){
        $uid=$userInfo['id'];
        if($userInfo['type']==2){
            //判断 pc是否登录 已登录 改为4 是pc和安卓一起在线
            $type=4;
        }elseif($userInfo['type']==5){
            //判断 ios和 pc是否同时在线 已在线 改为4 4是安卓和pc在线 把ios 踢掉线

            $type=4;
        }elseif($userInfo['type']==3){
            //判断 ios 是否在线 已在线 将ios 踢掉线 状态改为 1 1是安卓在线
            $type=1;
        }else{
            die('Android 已登录');
        }
        //更新数据库状态
        $res = ApiModel::where(['id'=>$uid])->update(['type'=>$type]);
        if($res==false){
            echo '登录失败';
        }
        $Android_token=rand(11111,99999);
        Redis::hdel("userLogin:id:$uid","ios_token");
        Redis::hset("userLogin:id:$uid",'Android_token',$Android_token);
    }
    //pc端登录
    public function pc($userInfo){
        $uid = $userInfo['id'];
        if ($userInfo['type']==1){
            //判断 安卓是否登录 已登录 改为4 是pc和安卓一起在线
           $type=4;
        }elseif ($userInfo['type']==3){
            //判断 ios 是否在线 已在线 改为5  pc和ios一起在线
            $type=5;
        }else{
            die('pc 已登录');
        }
        //更新数据库状态
        $res = ApiModel::where(['id'=>$uid])->update(['type'=>$type]);
        if($res===false){
            echo '登录失败';
        }
        $pc_token=rand(11111,99999);
        Redis::hset("userLogin:id:$uid",'pc_token',$pc_token);
    }
    //ios 登录
    public function ios($userInfo){
        $uid = $userInfo['id'];
        if ($userInfo['type']==1){
            //判断 安卓是否登录 已登录 改为3  ios登录 将安卓踢掉
            $type=3;
        }elseif ($userInfo['type']==4){
            //判断 pc 和安卓是否登录 已登录改为ios 和 pc 一起在线
            $type=5;
        }elseif ($userInfo['type']==2){
            //判断 pc 在线 改为5 ios 和 pc 在线
            $type=5;
        }else{
            die('ios 已登录');
        }
        //更新数据库状态
        $res = ApiModel::where(['id'=>$uid])->update(['type'=>$type]);
        if($res===false){
            echo '登录失败';
        }
        $ios_token=rand(11111,99999);
        Redis::hdel("userLogin:id:$uid","Android_token");
        Redis::hset("userLogin:id:$uid",'ios_token',$ios_token);
    }
}
