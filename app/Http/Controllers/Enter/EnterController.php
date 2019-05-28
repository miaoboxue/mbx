<?php

namespace App\Http\Controllers\Enter;

use App\Model\AdminModel;
use App\Model\ImgModel;
use App\Model\LinkModel;
use App\Model\NavModel;
use App\Model\NewOneModel;
use App\Model\NewsModel;
use App\Model\NotiModel;
use App\Model\UnitModel;
use App\Model\VkModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnterController extends Controller
{
    //
    //企业站首页
    public function index(){
        $link = LinkModel::where(['is_status'=>0])->get();
        $arr = NavModel::where(['is_status'=>0])->get();
        $new = NewOneModel::where(['is_status'=>0])->get()->toArray();
        $noti = NotiModel::where(['is_status'=>0])->get();

        $img = ImgModel::where(['id'=>2,'is_status'=>0])->get();
        $new_one = NewOneModel::where(['is_status'=>0])-> orderBy('add_time','desc')-> take(5)-> get();
        //单位分类
//        $vk_one = VkModel::where(['is_status'=>0])->get();
        $vk = VkModel::where(['is_status'=>0])->get()->toArray();
        //单位信息
        $unit = UnitModel::where(['is_status'=>0])->get();

        foreach($vk as $k=>$v){
            foreach($unit as $kk=>$vv){
                if($v['vk_id']==$vv['vk_id']){
                    $vk[$k]['unit_name'][]=$vv['unit_name'];
                }
            }
        }
        foreach($vk as $k=>$v){
            if(empty($v['unit_name'])){
                $vk[$k]['unit_name']=[];
            }
        }
//        var_dump($vk);die;
//        var_dump($new_one);die;
//      var_dump($new);die;
        $where=[
            'is_status'=>0,
            'is_del'=>0,
        ];
//        $news = NewsModel::join('new_one','news.news_id','=','new_one.news_id')->where($where)->get()->toArray();
        $news = NewsModel::where($where)->get()->toArray();
        foreach($news as $k=>$v){
            foreach($new as $kk=>$vv){
                if($v['news_id']==$vv['news_id']){
                    $news[$k]['new_name'][]=$vv['new_name'];
                }
            }
        }
//        var_dump($news);die;
        foreach($news as $k=>$v){
            if(empty($v['new_name'])){
                $news[$k]['new_name']=[];
            }
        }
//      var_dump($news);die;
        /*foreach($new as $val){
            foreach($news as $v){
                if($val['news_id']==$v['news_id']){
                    $data[$v['news_name']][]=$val['new_name'];
                }
            }
        }*/
        $info =[
            'arr'=>$arr,
            'new'=>$news,
            'link'=>$link,
//            'vk_one'=>$vk_one,
            'noti'=>$noti,
            'img'=>$img,
            'new_one'=>$new_one,
            'unit'=>$unit,
            'vk'=>$vk,
        ];
        return view('enter.index',$info);
    }

    //政策法规
    public function policies(){
        return view('enter.policies');
    }
    public function login(){
        return view('admin.login');
    }
    public function loginAll(Request $request){
        $uname = $_POST['uname'];
        $passwd = md5($_POST['pwd']);
        if (empty($uname)){
            return [
                'msg'=>'账号不能为空',
                'status'=>602,
            ];
        }
        if (empty($passwd)){
            return [
                'msg'=>'密码不能为空',
                'status'=>603,
            ];
        }
        $arr = AdminModel::where(['uname'=>$uname])->first();
//        var_dump($arr);die;
        if ($passwd==$arr['pwd']){
            $request->session()->get('uid',$arr['uid']);
            return [
                'msg'=>'登录成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'账号或密码错误',
                'status'=>604,
            ];
        }
    }
    public function quit(Request $request){
        $request->session()->flush('uid');
        if ($request->session()->exists('uid')==''){
            header('Location: /login');
        }
    }

    //办事指南
    public function gbook(){
        return view('enter.gbook');
    }
}
