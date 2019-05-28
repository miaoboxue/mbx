<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>修改导航栏 - 导航栏管理 </title>
</head>
<body>
<article class="page-container">
    <div class="form form-horizontal" id="form-admin-add">
        <input type="hidden" value="{{$arr['nav_id']}}" id="nav_id">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>导航栏名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="nav_name"  id="name_nav" value="{{$arr['nav_name']}}" class="input-text">

            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>导航栏地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="nav_url"  id="nav_url" value="{{$arr['nav_url']}}" class="input-text">

            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>父分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <dl class="permission-list">
                    <select id="is_status" name="is_status" size="1">
                        <option value="">--请选择--</option>
                        @if($arr['is_status']==0)
                            <option value="0" selected>是</option>
                            <option value="1">否</option>
                        @else
                            <option value="0" >是</option>
                            <option value="1" selected>否</option>
                        @endif
                    </select>
                </dl>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="button" id="btn" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </div>
</article>
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script>
    $(function () {
        $("#name_nav").blur(function () {
            var nav_name = $("#name_nav").val()
            if (nav_name == ''){
                alert('导航栏名称不能为空')
            }
        })
        $("#nav_url").blur(function () {
            var nav_url = $("#nav_url").val()
            if (nav_url == ''){
                alert('导航栏地址不能为空')
            }
        })
        $("#btn").click(function () {
            var nav_name = $("#name_nav").val()
            var status= $("#is_status").val()
            var nav_url = $("#nav_url").val()
            var nav_id = $("#nav_id").val()
            $.post(
                '/nav/updateall',
                {nav_name:nav_name,nav_url:nav_url,status:status,nav_id:nav_id},
                function (msg) {
                    console.log(msg)
                    if(msg.status==5400){
                        alert('导航栏名称不能为空')
                    }else if (msg.status==506){
                        alert('导航栏地址不能为空')
                    }else if (msg.status==550){
                        alert('请选择是否展示')
                    }else if (msg.status==5500){
                        alert('此导航栏名称已存在')
                    }else if (msg.status==5600){
                        alert('修改失败')
                    }else{
                        alert('修改成功')
                        location.href ="/nav/list";
                    }
                }
            )

        })
    })
</script>

