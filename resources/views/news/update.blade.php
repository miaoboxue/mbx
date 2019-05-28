
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
    <title>添加新闻 - 新闻管理 </title>
</head>
<body>
<article class="page-container">
    <div class="form form-horizontal" id="form-admin-add">
        <input type="hidden" name="news_id" value="{{$arr['news_id']}}" id="news_id">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新闻类型名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="news_name"  id="news_name" value="{{$arr['news_name']}}" class="input-text">

            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>父分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <dl class="permission-list">
                    <select id="nav_id" name="nav_id" size="1">
                        <option value="">--请选择--</option>
                        <?php foreach($info as $v){ ?>
                            @if($v['nav_id']==$arr['nav_id'])
                                <option value="{{$v['nav_id']}}" selected>{{$v['nav_name']}}</option>
                            @else
                                <option value="{{$v['nav_id']}}">{{$v['nav_name']}}</option>
                            @endif
                        <?php } ?>
                    </select>
                </dl>
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
        $("#news_name").blur(function () {
            var news_name = $("#news_name").val();
            if (news_name == ''){
                alert("新闻类型不能为空")
            }
        });
        //
        $("#btn").click(function () {
            var news_name = $("#news_name").val();
            var is_status=$("#is_status").val();
            var nav_id = $("#nav_id").val();
            var news_id=$("#news_id").val();
            $.post(
                '/news/updateall',
                {news_name:news_name,nav_id:nav_id,is_status:is_status,news_id:news_id},
                function (msg) {
                    console.log(msg)
                    if(msg.status=='1500'){
                        alert('新闻类型不能为空')
                    }else if (msg.status=='1200'){
                        alert('请选择父分类')
                    }else if (msg.status=='5002'){
                        alert('修改失败')
                    }else{
                        alert('修改成功')
                    }
                }
            )
        })
    })
</script>
