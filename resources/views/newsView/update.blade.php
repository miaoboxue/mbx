
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>修改新闻 - 新闻管理 </title>
</head>
<body>
<article class="page-container">
    <div class="form form-horizontal" id="form-admin-add">
        <input type="hidden" name="new_id" value="{{$arr['new_id']}}" id="new_id">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新闻名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="new_name"  id="new_name" value="{{$arr['new_id']}}" class="input-text">

            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>新闻内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="new_text" id="new_text" cols="30" rows="10">{{$arr['new_text']}}</textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>父分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <dl class="permission-list">
                    <select id="news_id" name="news_id" size="1">
                        <option value="">--请选择--</option>
                        <?php foreach($info as $v){ ?>
                            @if($v['news_id']==$arr['news_id'])
                                <option value="{{$v['news_id']}}" selected>{{$v['news_name']}}</option>
                            @else
                                <option value="{{$v['news_id']}}">{{$v['news_name']}}</option>
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
        $("#new_name").blur(function () {
            var new_name = $("#new_name").val();
            if (new_name == ''){
                alert("新闻标题不能为空")
            }
        })
        $("#new_text").blur(function () {
            var new_text = $("#new_text").val();
            if (new_text == ''){
                alert("新闻内容不能为空")
            }
        })
        $("#btn").click(function () {
            var new_name = $("#new_name").val();
            // console.log(new_name)
            var new_text = $("#new_text").val();
            // console.log(new_text)
            var is_status = $("#is_status").val();
            // console.log(is_status)
            var news_id = $("#news_id").val();
            // console.log(news_id)
            var new_id = $("#new_id").val();
            $.post(
                '/newAdd/Up',
                {new_name:new_name,new_text:new_text,news_id:news_id,is_status:is_status,new_id:new_id},
                function (msg) {
                    console.log(msg)
                    if (msg.status==540){
                        alert('新闻标题不能为空')
                    }else if(msg.status==550){
                        alert('新闻内容不能为空')
                    }else if (msg.status==560){
                        alert('请选择新闻类型')
                    }else if (msg.status==570){
                        alert('修改失败')
                    }else if (msg.status==200){
                        alert('修改成功')
                    }
                }
            )
        })
    })
</script>