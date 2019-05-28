
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
    <title>添加相关连接 - 链接管理 </title>
</head>
<body>
<article class="page-container">
    <div class="form form-horizontal" id="form-admin-add">
        <input type="hidden" name="link_id" value="{{$arr['link_id']}}" id="link_id">

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>相关连接名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="link_name"  id="link_name" value="{{$arr['link_name']}}" class="input-text">

            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>链接地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="link_url" value="{{$arr['link_url']}}" id="link_url"  class="input-text">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>是否展示：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <dl class="permission-list">
                    <select id="is_status" name="is_status" size="1">
                        <option value="">--请选择--</option>
                        @if($arr['is_status']==0)
                            <option value="0" selected>是</option>
                            <option value="1">否</option>
                        @else
                            <option value="0">是</option>
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
        $("#link_name").blur(function () {
            var link_name = $("#link_name").val();
            if (link_name == ''){
                alert('相关连接名称不能为空')
            }
        })
        $("#link_url").blur(function () {
            var link_url = $("#link_url").val();
            if (link_url == ''){
                alert('连接地址不能为空')
            }
        })
        $("#btn").click(function () {
            var link_name = $("#link_name").val();
            var is_status = $("#is_status").val();
            var link_url = $("#link_url").val();
            var link_id = $("#link_id").val();

            $.post(
                '/link/upadd',
                {link_name:link_name,is_status:is_status,link_url:link_url,link_id:link_id},
                function (msg) {
                    if (msg.status==503){
                        alert('相关连接名称不能为空')
                    } else if (msg.status==505) {
                        alert('请选择是否展示')
                    }else if (msg.status==507){
                        alert('连接地址不能为空')
                    } else if (msg.status==506){
                        alert('修改失败')
                    } else if (msg.status==200){
                        alert('修改成功')
                    }
                }
            )

        })
    })
</script>