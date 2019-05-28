<?php

namespace App\Http\Controllers\Admin;

//use App\Model\CateModel;
use App\Model\PowerModel;
use App\Model\RoleModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdminModel;
use App\Model\NavModel;
use App\Model\RolePower;
use App\Model\RoleUser;
use Illuminate\Support\Facades\DB;
class  UserController extends Controller
{
    public function checkLogin(Request $request){
        $uname = $request->input('admin_name');
        $pwd = $request->input('pwd');
        $where=[
            'uname'=>$uname
        ];
        $data = AdminModel::where($where)->first();
        if(empty($data) || $data->pwd!==md5($pwd)){
            $resopnse=[
                'code'=>50001,
                'msg'=>'账号或密码错误！'
            ];
            echo json_encode($resopnse);die;
        }else{
            $token = substr(md5(time().mt_rand(1,99999)),10,10);
            $request->session()->put('u_token',$token);
            $request->session()->put('uid',$data->uid);
            $request->session()->put('uname',$uname);
            $updata=[
                'last_login_time'=>time()
            ];
            AdminModel::where($where)->update($updata);
            $resopnse=[
                'code'=>0,
                'msg'=>'登陆成功'
            ];
            echo json_encode($resopnse);
        }
    }
    //管理员添加
    public function adminAddDo(Request $request){
        $data = $request->input();
        $uname=$data['uname'];
        $info=AdminModel::where(['uname'=>$uname])->first();
        if(!empty($info)){
            $resopnse=[
                'code'=>5003,
                'msg'=>'账号已注册'
            ];
            echo json_encode($resopnse);die;
        }
        //开启事务
        DB::beginTransaction();
        try{
            //入管理员表
            $adminData =[
                'uname'=>$data['uname'],
                'pwd'=>md5($data['pwd']),
                'tel'=>$data['tel'],
                'email'=>$data['email'],
                'add_time'=>time(),
            ];
            $uid =AdminModel::insertGetId($adminData);
            if($uid  <0){
                throw new \Exception('管理员表写入失败');
            }
            $role_id_arr=explode(',',$data['role_id']);
            $role_arr =[];
            foreach($role_id_arr as $k=>$v){
                $role_arr[$k]['uid']=$uid;
                $role_arr[$k]['role_id']=$v;
            }
            RoleUser::insert($role_arr);
            //提交事务
            DB::commit();
            return json_encode(['code'=>0,'msg'=>'添加成功']);
        }catch(\Exception $e){
            //回滚
            DB::rollback();
            throw $e;
        }
    }
    //管理员展示
    public function adminList(){
        $adminList=AdminModel::all()->toArray();
//        $adminInfo=[];
//        foreach($adminList as $k=>$v){
//            $where=[
//                'role_id'=>$v['role_id']
//            ];
//            $role_name=RoleModel::where($where)->first();
//            $data['uid']=$v['uid'];
//            $data['uname']=$v['uname'];
//            $data['tel']=$v['tel'];
//            $data['email']=$v['email'];
//            $data['role_name']=$role_name['role_name'];
//            $data['add_time']=$v['add_time'];
//            $data['last_login_time']=$v['last_login_time'];
//            $adminInfo[]=$data;
//        }
        return view('admin.adminlist',['adminInfo'=>$adminList]);
    }
    //管理员删除
    public function adminDel(Request $request){
        $uid=$request->input('uid');
        //开启事务
        DB::beginTransaction();
        try{
            $where=[
                'uid'=>$uid
            ];
            AdminModel::where($where)->delete();
            RoleUser::where($where)->delete();
            //提交事务
            DB::commit();
            return json_encode(['code'=>0,'msg'=>'删除成功']);
        }catch(\Exception $e){
            //回滚
            DB::rollback();
            throw $e;
        }

    }
    //修改密码
    public function adminPwd(Request $request){
        $pwd=$request->input('pwd');
        $pd2=$request->input('new_pwd');
        $where=[
            'uid'=>session('uid')
        ];
        $info=AdminModel::where($where)->first();
        //dump($info);die;
        if(md5($pwd) !== $info->pwd){
            $arr = [
                'code' => 404,
                'msg' => '原密码错误'
            ];
            echo json_encode($arr);
            die;
        }else{
            $res=AdminModel::where($where)->update(['pwd'=>md5($pd2)]);
            if($res){
                $arr = [
                    'code' => 0,
                    'msg' => '修改成功'
                ];
                echo json_encode($arr);
            }
        }
    }
    //管理员修改
    public function adminUpdateDo(Request $request){
        $role_id = $request->input('role_id');
        $uname = $request->input('uname');
        //开启事务
        DB::beginTransaction();
        try{
            $where=[
                'uname'=>$uname
            ];
            $adminData =[
                'tel'=>$request->input('tel'),
                'email'=>$request->input('email'),
            ];
            AdminModel::where($where)->update($adminData);
            $data=AdminModel::where($where)->first();
            RoleUser::where(['uid'=>$data['uid']])->delete();
            $role_id_arr=explode(',',$role_id);
            $role_arr =[];
            foreach($role_id_arr as $k=>$v){
                $role_arr[$k]['uid']=$data['uid'];
                $role_arr[$k]['role_id']=$v;
            }
            RoleUser::insert($role_arr);//加入关联表
            //提交事务
            DB::commit();
            return json_encode(['code'=>0,'msg'=>'修改成功']);
        }catch(\Exception $e){
            //回滚
            DB::rollback();
            throw $e;
        }
    }
    //权限添加
    public function checkpower(Request $request){
        $action_name=$request->input('action_name');
        $is_show=$request->input('is_show');
        $datawhere=[
            'action_name'=>$action_name
        ];
        $info=PowerModel::where($datawhere)->first();
        if($info){
            $arr = [
                'code' => 404,
                'msg' => '功能已存在'
            ];
            echo json_encode($arr);
            die;
        }
        $action_url=$request->input('action_url');
        $pid=$request->input('pid');
        $data=[
            'action_name'=>$action_name,
            'action_url'=>$action_url,
            'pid'=>$pid,
            'is_show'=>$is_show
        ];
        //print_r($data);die;
        $res=PowerModel::insertGetId($data);
        if($res){
            $arr = [
                'code' => 0,
                'msg' => '添加成功'
            ];
            echo json_encode($arr);
        }else{
            $arr = [
                'code' => 4004,
                'msg' => '添加失败'
            ];
            echo json_encode($arr);
            die;
        }
    }
    //权限删除
    public function powerDel(Request $request){
        $action_id=$request->input('action_id');
        $where=[
            'action_id'=>$action_id
        ];
        $powerInfo=PowerModel::where(['pid'=>0])->pluck('action_id')->toArray();
        if(in_array($action_id,$powerInfo)==true){
            $arr = [
                'code' => 4004,
                'msg' => '分类不可删除'
            ];
            echo json_encode($arr);die;
        }
        //print_r($where);die;
        $res=PowerModel::where($where)->delete();
        if($res){
            $arr = [
                'code' => 0,
                'msg' => '删除成功'
            ];
            echo json_encode($arr);
        }else{
            $arr = [
                'code' => 4003,
                'msg' => '删除失败'
            ];
            echo json_encode($arr);die;
        }
    }
    //权限修改
    public function powerupdate(Request $request)
    {
        $action_name = $request->input('action_name');
        $is_show = $request->input('is_show');
        $pid = $request->input('pid');
        $action_url=$request->input('action_url');
        $where = [
            'action_name' => $action_name
        ];
        $date=[
            'is_show'=>$is_show,
            'pid'=>$pid,
            'action_url'=>$action_url
        ];
        $res = PowerModel::where($where)->update($date);
        if ($res) {
            $arr = [
                'code' => 0,
                'msg' => '修改成功'
            ];
            echo json_encode($arr);
        } else {
            $arr = [
                'code' => 4004,
                'msg' => '修改失败'
            ];
            echo json_encode($arr);
            die;
        }
    }
    //执行添加角色
    public function checkRole(Request $request){
        $data=$request->input();
        //print_r($data);die;
        DB::beginTransaction();
        try{
            //入角色表
            $roleData =[
                'role_name'=>$data['role_name'],
                'content'=>$data['content'],
            ];
            $roleinfo=RoleModel::where($roleData)->first();
            if($roleinfo){
                $arr = [
                    'code' => 404,
                    'msg' => '角色已存在'
                ];
                echo json_encode($arr);
                die;
            }
            $role_id =RoleModel::insertGetId($roleData);
            if($role_id  <0){
                throw new \Exception('角色表写入失败');
            }
            $action_id_arr=explode(',',$data['action_id']);
            $action_arr =[];
            foreach($action_id_arr as $k=>$v){
                $action_arr[$k]['role_id']=$role_id;
                $action_arr[$k]['action_id']=$v;
            }
            RolePower::insert($action_arr);//加入关联表
            //提交事务
            DB::commit();
            return json_encode(['code'=>0,'msg'=>'添加成功']);
        }catch(\Exception $e){
            //回滚
            DB::rollback();
            throw $e;
        }
    }
    //角色修改
    public function roleupdate(Request $request){
        $data=$request->input();
        DB::beginTransaction();
        try{
            //入角色表
            $roleData =[
                'role_name'=>$data['role_name'],
            ];
            $roleinfo=RoleModel::where($roleData)->first()->toarray();
            $actData=[
                'role_id'=>$roleinfo['role_id']
            ];
            RolePower::where($actData)->delete();
            $action_id_arr=explode(',',$data['action_id']);
            $action_arr =[];
            foreach($action_id_arr as $k=>$v){
                $action_arr[$k]['role_id']=$roleinfo['role_id'];
                $action_arr[$k]['action_id']=$v;
            }
            RolePower::insert($action_arr);//加入关联表
            //提交事务
            DB::commit();
            return json_encode(['code'=>0,'msg'=>'修改成功']);
        }catch(\Exception $e){
            //回滚
            DB::rollback();
            throw $e;
        }
    }
    //角色删除
    public function roleDel(Request $request){
        $role_id=$request->input('role_id');
        //开启事务
        DB::beginTransaction();
        try{
            $where=[
                'role_id'=>$role_id
            ];
            $info=RoleUser::where($where)->get()->toarray();
            //print_r($info);die;
            if(!empty($info)){
                return json_encode(['code'=>3001,'msg'=>'此角色被选择,不能删除']);
            }
            RoleModel::where($where)->delete();
            RolePower::where($where)->delete();
            //提交事务
            DB::commit();
            return json_encode(['code'=>0,'msg'=>'删除成功']);
        }catch(\Exception $e){
            //回滚
            DB::rollback();
            throw $e;
        }
    }
    //导航栏添加
    public function checkarticle(Request $request){
        $data = $request->input();
        $nav_name=$data['nav_name'];
        $info=NavModel::where(['nav_name'=>$nav_name])->first();
        if(!empty($info)){
            $resopnse=[
                'code'=>5003,
                'msg'=>'导航标题已存在'
            ];
            echo json_encode($resopnse);die;
        }
        $navData =[
            'nav_name'=>$data['nav_name'],
            'nav_url'=>$data['nav_url'],
            'nav_sorce'=>$data['nav_sorce'],
            'is_show'=>$data['is_show'],
        ];
        $res =NavModel::insertGetId($navData);
        if($res){
            $resopnse=[
                'code'=>0,
                'msg'=>'添加成功'
            ];
            echo json_encode($resopnse);die;
        }
    }
    //导航栏修改
    public function checkupart(Request $request){
        $data = $request->input();
        $navData =[
            'nav_url'=>$data['nav_url'],
            'nav_sorce'=>$data['nav_sorce'],
            'is_show'=>$data['is_show'],
            'update_time'=>time()
        ];
        $res =NavModel::where(['nav_name'=>$data['nav_name']])->update($navData);
        if($res){
            $resopnse=[
                'code'=>0,
                'msg'=>'修改成功'
            ];
            echo json_encode($resopnse);
        }
    }
    //导航栏删除
    public function navDel(Request $request){
        $nav_id=$request->input('nav_id');
        $where=[
            'nav_id'=>$nav_id
        ];
        $res=NavModel::where($where)->delete();
        if($res){
            $arr = [
                'code' => 0,
                'msg' => '删除成功'
            ];
            echo json_encode($arr);
        }else{
            $arr = [
                'code' => 4003,
                'msg' => '删除失败'
            ];
            echo json_encode($arr);die;
        }
    }
    //添加分类
    public function checkcate(Request $request){
        $data = $request->input();
        $cate_name=$data['cate_name'];
        $info=CateModel::where(['cate_name'=>$cate_name])->first();
        if(!empty($info)){
            $resopnse=[
                'code'=>5003,
                'msg'=>'分类已存在'
            ];
            echo json_encode($resopnse);die;
        }
        $cateData =[
            'cate_name'=>$data['cate_name'],
            'is_show'=>$data['is_show'],
            'add_time'=>time(),
        ];
        $res =CateModel::insertGetId($cateData);
        if($res){
            $resopnse=[
                'code'=>0,
                'msg'=>'添加成功'
            ];
            echo json_encode($resopnse);die;
        }
    }
    //分类修改
    public function cateupdate(Request $request){
        $data = $request->input();
        $cateData =[
            'is_show'=>$data['is_show'],
            'update_time'=>time()
        ];
        $res =CateModel::where(['cate_name'=>$data['cate_name']])->update($cateData);
        if($res){
            $resopnse=[
                'code'=>0,
                'msg'=>'修改成功'
            ];
            echo json_encode($resopnse);
        }
    }
    //分类删除
    public function cateDel(Request $request){
        $cate_id=$request->input('cate_id');
        $where=[
            'cate_id'=>$cate_id
        ];
        $res=CateModel::where($where)->delete();
        if($res){
            $arr = [
                'code' => 0,
                'msg' => '删除成功'
            ];
            echo json_encode($arr);
        }else{
            $arr = [
                'code' => 4003,
                'msg' => '删除失败'
            ];
            echo json_encode($arr);die;
        }
    }
}