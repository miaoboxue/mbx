<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//api
Route::post('/login','Index\IndexController@login')->middleware('checkapi');
//image
Route::post('/image','Index\IndexController@image');

//验证码
Route::post('/vcode','Vcode\VcodeController@vcode');


Route::get('/num/{x}','Num\NumController@num');




Route::get('/showVcode/{sid}','Vcode\VcodeController@showVcode');

Route::post('/checkShow','Vcode\VcodeController@checkShow');


//type == 安卓  ==  pc  ==  ios
Route::post('/type','Api\ApiController@type');



//企业站
//首页
Route::get('/index','Enter\EnterController@index');
//政策法规
Route::get('/index/list','Enter\EnterController@policies');
//办事指南
Route::get('/index/gbook','Enter\EnterController@gbook');
Route::get('/index/new','Enter\EnterController@');


//后台
//Route::get('/admin/index','Admin\AdminController@layout');
Route::get('/login','Enter\EnterController@login');
Route::post('/admin/login','Enter\EnterController@loginAll');
Route::get('/admin/quit','Enter\EnterController@quit');
//管理员
/*
//管理员添加试图
Route::get('/admin/user','Admin\AdminController@user');
//管理员添加
Route::post('/admin/all','Admin\AdminController@all');
//管理员列表
Route::get('/admin/list','Admin\AdminController@list');
//管理员列表数据接口
Route::get('/admin/table','Admin\AdminController@table');*/
/*
//管理员删除
Route::post('/admin/delete','Admin\AdminController@delete');

//管理员修改试图
Route::get('/admin/update/{uid}','Admin\AdminController@update');

//管理员修改
Route::post('/admin/updateall','Admin\AdminController@updateall');*/



//导航栏添加试图
Route::get('/nav/navview','Nav\NavController@nav');
//导航栏添加
Route::post('/nav/all','Nav\NavController@navall');
//导航栏列表
Route::get('/nav/list','Nav\NavController@list');
//列表数据
Route::get('/nav/table/','Nav\NavController@table');
//删除
Route::post('/nav/delete','Nav\NavController@delete');
//修改
Route::get('/nav/update/{nav_id}','Nav\NavController@update');
Route::post('/nav/updateall','Nav\NavController@updateall');



//新闻分类添加
Route::get('/news/addview','News\NewsController@view');
Route::post('/news/all','News\NewsController@all');
Route::get('/news/list','News\NewsController@list');
Route::get('/news/table/','News\NewsController@table');
Route::post('/news/delete','News\NewsController@delete');
Route::get('/news/update/{news_id}','News\NewsController@update');
Route::post('/news/updateall','News\NewsController@updateall');


//直属单位
Route::get('/vk/view','Vk\VkController@view');
Route::post('/vk/all','Vk\VkController@all');
Route::get('/vk/list','Vk\VkController@list');
Route::get('/vk/table/','Vk\VkController@table');
Route::post('/vk/delete','Vk\VkController@delete');
Route::get('/vk/update/{vk_id}','Vk\VkController@update');
Route::post('/vk/updateall','Vk\VkController@updateall');

//直属单位信息
Route::get('/unit/view','Unit\UnitController@view');
Route::post('/unit/all','Unit\UnitController@all');
Route::get('/unit/list','Unit\UnitController@list');
Route::get('/unit/table','Unit\UnitController@table');
Route::post('/unit/delete','Unit\UnitController@delete');
Route::get('/unit/update/{unit_id}','Unit\UnitController@update');
Route::post('/unit/updateall','Unit\UnitController@updateall');
Route::get('/unit/info/{unit_name}','Unit\UnitController@unitInfo');


//文件上传
Route::get('/img/view','Img\ImgController@view');
Route::post('/img/imgAll','Img\ImgController@imgAll');
Route::post('/img/imgData','Img\ImgController@imgData');
Route::get('/img/imgList','Img\ImgController@list');
Route::get('/img/table','Img\ImgController@table');
Route::post('/img/delete','Img\ImgController@delete');



//新闻添加

Route::get('/newsAdd/newsView','News\NewsController@newsView');
Route::post('/newsAdd/newsAll','News\NewsController@newsAdd');
Route::get('/newsAdd/newsList','News\NewsController@newsList');
Route::get('/newsAdd/table','News\NewsController@newsTable');
Route::post('/newsAdd/newDelete','News\NewsController@newsDelete');
Route::get('/newAdd/newsUpdate/{new_id}','News\NewsController@newsUpdate');
Route::post('/newAdd/Up','News\NewsController@newsUp');
Route::get('/new/info/{new_name}','News\NewsController@newInfo');


//相关连接
Route::get('/link/linkView','Link\LinkController@view');
Route::post('/link/linkAdd','Link\LinkController@add');
Route::get('/link/linkList','Link\LinkController@list');
Route::get('/link/table','Link\LinkController@table');
Route::post('/link/delete','Link\LinkController@delete');
Route::get('/link/update/{link_id}','Link\LinkController@update');
Route::post('/link/upadd','Link\LinkController@upadd');


//通知公告
Route::get('/noti/notiView','Noti\NotiController@view');
Route::post('/noti/all','Noti\NotiController@all');
Route::get('/noti/notiList','Noti\NotiController@list');
Route::get('/noti/table','Noti\NotiController@table');
Route::post('/noti/delete','Noti\NotiController@delete');
Route::get('/noti/update/{noti_id}','Noti\NotiController@update');
Route::post('/noti/upAll','Noti\NotiController@upAll');






//后台首页
Route::get('/admin','Admin\AdminController@index');
Route::get('/welcome','Admin\AdminController@welcome');
//登录
Route::get('/adminlogin','Admin\AdminController@admin');
Route::post('/login/do','Admin\UserController@checkLogin');
//管理员列表
Route::get('/adminlist','Admin\UserController@adminList');
//管理员角色
Route::get('/userrole/{uid}','Admin\AdminController@userrole');
//管理员添加
Route::get('/adminadd','Admin\AdminController@adminadd');
Route::post('/add/do','Admin\UserController@adminAddDo');
//管理员修改
Route::get('/adminupdate/{uid}','Admin\AdminController@adminUpdate');
Route::post('/adminupd/do','Admin\UserController@adminUpdateDo');
//管理员删除
Route::post('/adminDel','Admin\UserController@adminDel');
//修改密码
Route::get('/pwd','Admin\AdminController@pwdupdate');
Route::post('/pwd/do','Admin\UserController@adminPwd');

//角色添加
Route::get('/roleadmin','Admin\AdminController@adminrole');
Route::post('/role/do','Admin\UserController@checkRole');
//角色展示
Route::get('/rolelist','Admin\AdminController@rolelist');
//角色修改
Route::get('/roleupdate/{role_id}','Admin\AdminController@roleupdate');
Route::post('/roleupdate/do','Admin\UserController@roleupdate');
//角色删除
Route::post('/roleDel','Admin\UserController@roleDel');
//权限添加
Route::get('/poweradd','Admin\AdminController@poweradd');
Route::post('/poweradd/do','Admin\UserController@checkpower');
//权限展示
Route::get('/powerlist','Admin\AdminController@powerlist');
//权限删除
Route::post('/powerDel','Admin\UserController@powerDel');
//权限修改
Route::get('/powerupdate/{action_id}','Admin\AdminController@powerupdate');
Route::post('/powerupdate/do','Admin\UserController@powerupdate');

//退出
Route::get('/quit','Admin\AdminController@quit');








