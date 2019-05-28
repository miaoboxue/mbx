<?php

namespace App\Http\Controllers\Admin;

use App\Model\AdminModel;
use App\Model\PowerModel;
use App\Model\RoleUser;
use App\Model\RolePower;
use App\Model\RoleModel;
use Encore\Admin\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //后台首页
    public function layout(){
        return view('admin.index');
    }
    //管理员添加试图
    public function user(){
        return view('admin.user');
    }

    //管理员添加
    public function all(){
//        var_dump($_POST);
        $uname=$_POST['uname'];
        $passwd=$_POST['passwd'];
        $tel=$_POST['tel'];
        $email=$_POST['email'];
        //验证唯一性
      /*  $arr=AdminModel::where(['uname'=>$uname])->first();
        var_dump($arr);

        if ($arr) {
            $data= [
                'msg'=>'Account already exists',
                'status'=>400,
            ];
        }*/
//        var_dump($arr);
        //账号不能为空
        if (empty($uname)){
            return [
                'msg'=>'The account cannot be empty',
                'status'=>1500,
            ];
        }
        if (empty($tel)){
            return [
                'msg'=>'The account cannot be empty',
                'status'=>1600,
            ];
        }
        if (empty($email)){
            return [
                'msg'=>'The account cannot be empty',
                'status'=>1700,
            ];
        }
        //密码不能为空
        if (empty($passwd)){
            return [
                'msg'=>'The password cannot be empty',
                'status'=>1200,
            ];
        }

        $data=[
            'uname'=>$uname,
            'passwd'=>$passwd,
            'add_time'=>time()
        ];
        //管理员信息入库
        $res=AdminModel::insert($data);
        if($res){
            return [
                'msg'=>'添加成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'添加失败',
                'status'=>5002,
            ];
        }
    }

    //管理员列表
    public function list(){
        return view('admin.list');
    }

    //管理员列表数据
    public function table(){
        $arr=AdminModel::get();
//        return $arr;
//        var_dump($arr);die;
        return [
            'code'=>'0',
            'data'=>$arr,
        ];
    }

    //管理员删除
    public function delete(){
        $uid= $_POST['uid'];
        $res=AdminModel::where(['uid'=>$uid])->delete();
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

    //管理员修改
    public function update($uid){
        $arr=AdminModel::where(['uid'=>$uid])->first();
//        var_dump($arr);die;
        return view('admin.update',['arr'=>$arr]);
    }

    //修改更新数据
    public function updateall(){
        $uname = $_POST['uname'];
        $passwd = $_POST['passwd'];
//        var_dump($_POST);die;
        $uid= $_POST['uid'];
        //账号不能为空
        if (empty($uname)){
            return [
                'msg'=>'The account cannot be empty',
                'status'=>1500,
            ];
        }
        //密码不能为空
        if (empty($passwd)){
            return [
                'msg'=>'The password cannot be empty',
                'status'=>1200,
            ];
        }

        $data=[
            'uname'=>$uname,
            'passwd'=>$passwd,
        ];
        $res = AdminModel::where(['uid'=>$uid])->update($data);
//        var_dump($res);die;
        if($res){
            return [
                'msg'=>'修改成功',
                'status'=>200,
            ];
        }else{
            return [
                'msg'=>'修改失败',
                'status'=>5002,
            ];
        }
    }






    public function index(){
        return view('admin.index');
    }
    public function admin(){
        return view('admin.login');
    }
    public function welcome(){
        return view('admin.welcome');
    }
    //管理员添加
    public function adminadd(){
        $list=RoleModel::all()->toArray();
        return view('admin.adminadd',['data'=>$list]);
    }
    //管理员修改
    public function adminUpdate($uid){
        $data=RoleModel::all()->toArray();
        $adminrole=AdminModel::where(['uid'=>$uid])->first();
        $roleInfo=RoleUser::where(['uid'=>$uid])->pluck('role_id')->toarray();
        $info=[
            'data'=>$data,
            'adminrole'=>$adminrole,
            'roleInfo'=>$roleInfo
        ];
        return view('admin.adminupdate',$info);
    }
    //管理员角色展示
    public function userrole($uid){
        $data=RoleModel::all()->toArray();
        $list=RoleUser::where(['uid'=>$uid])->pluck('role_id')->toarray();
        $uname=AdminModel::where(['uid'=>$uid])->pluck('uname')->first();
        $info=[
            'data'=>$data,
            'adminrole'=>$list,
            'uname'=>$uname,
        ];
        return view('admin.admin_role',$info);
    }
    //密码修改
    public function pwdupdate(){
        return view('admin.pwdupdate');
    }
    //展示权限
    public function getSon($data,$pid=0){
        $powerInfo=[];
        foreach($data as $k=>$v){
            if($v['pid']==$pid){
                $son=$this->getSon($data,$v['action_id']);
                $v['son']=$son;
                $powerInfo[]=$v;
            }
        }
        return $powerInfo;
    }
    //角色添加
    public function adminrole(){
        $info = PowerModel::all()->toarray();
        $powerInfo=$this->getSon($info);
        $data=[
            'powerInfo'=>$powerInfo
        ];
        return view('admin.roleadd',$data);
    }
    //角色展示
    public function rolelist(){
        $roleDate=RoleModel::all()->toArray();
        return view('admin.rolelist',['roleDate'=>$roleDate]);
    }
    //角色修改
    public function roleupdate($rode_id){
        $where=[
            'role_id'=>$rode_id
        ];
        $info=RoleModel::where($where)->first()->toarray();
        $powerInfo=RolePower::where($where)->pluck('action_id')->toarray();
        //print_r($powerInfo);die;
        $infopower = PowerModel::all()->toarray();
        $powerdata=$this->getSon($infopower);
        $data=[
            'roleinfo'=>$info,
            'powerdata'=>$powerdata,
            'powerinfo'=>$powerInfo
        ];
        //print_r($data);die;
        return view('admin.roleupdate',$data);
    }
    //权限展示
    public function powerlist(){
        $Info=PowerModel::where(['is_show'=>1])->get()->toArray();
        return view('admin.powerlist',['powerinfo'=>$Info]);
    }
    //权限添加
    public function poweradd(){
        $powerInfo=PowerModel::where(['pid'=>0])->get()->toArray();
        return view('admin.poweradd',['powerInfo'=>$powerInfo]);
    }
    //权限修改
    public function powerupdate($action_id){
        $where=[
            'action_id'=>$action_id
        ];
        $data=PowerModel::where($where)->first();
        $powerInfo=PowerModel::where(['pid'=>0])->get()->toArray();
        $info=[
            'data'=>$data,
            'powerInfo'=>$powerInfo
        ];
        return view('admin.powerupdate',$info);
    }
    //导航栏添加
    public function articleadd(){
        return view('news.articleadd');
    }
    //导航栏展示
    public function articlelist(){
        $navInfo=NavModel::all()->toArray();
        return view('news.articlelist',['navInfo'=>$navInfo]);
    }
    //导航栏修改
    public function articleupdate($nav_id){
        $navInfo=NavModel::where(['nav_id'=>$nav_id])->first();
        return view('news.articleupdate',['navInfo'=>$navInfo]);
    }
    //分类添加
    public function cateadd(){
        return view('cate.cateadd');
    }
    //分类展示
    public function catelist(){
        $cateInfo=CateModel::all()->toArray();
        return view('cate.catelist',['cateInfo'=>$cateInfo]);
    }
    //分类修改
    public function cateupdate($cate_id){
        $cateInfo=CateModel::where(['cate_id'=>$cate_id])->first();
        return view('cate.cateupdate',['cateInfo'=>$cateInfo]);
    }
    //新闻添加
    public function newsadd(){
        return view('news.newsadd');
    }
    //新闻展示
    public function newslist(){
        $cateInfo=CateModel::all()->toArray();
        return view('cate.catelist',['cateInfo'=>$cateInfo]);
    }
    //新闻修改
    public function newsupdate($news_id){
        $cateInfo=CateModel::where(['cate_id'=>$cate_id])->first();
        return view('cate.cateupdate',['cateInfo'=>$cateInfo]);
    }
    public function quit(){
        session()->flush('uname');
        header('refresh:0.2;/adminlogin');
    }

}
