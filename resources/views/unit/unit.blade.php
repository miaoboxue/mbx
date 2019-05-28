
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
    <title>直属单位信息添加 - 单位管理 </title>
</head>
<body>
<article class="page-container">
    <div class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>直属单位信息名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="unit_name"  id="unit_name"  class="input-text">

            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>直属单位信息内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="unit_text" id="unit_text" cols="30" rows="10"></textarea>

            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>父分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <dl class="permission-list">
                    <select id="vk_id" name="vk_id" size="1">
                        <option value="">--请选择--</option>
                        <?php foreach($arr as $v){ ?>
                            <option value="{{$v['vk_id']}}">{{$v['vk_name']}}</option>
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
                        <option value="0">是</option>
                        <option value="1">否</option>
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
        $("#unit_name").blur(function () {
            var unit_name = $("#unit_name").val();
            if (unit_name == ''){
                alert("单位信息名称不能为空")
            }
        })
        $("#unit_text").blur(function () {
            var unit_text = $("#unit_text").val();
            if (unit_text == ''){
                alert("单位信息不能为空")
            }
        })
        $("#btn").click(function () {
            var unit_name = $("#unit_name").val();
            var unit_text = $("#unit_text").val();
            var is_status = $("#is_status").val();
            var vk_id = $("#vk_id").val();
            $.post(
                '/unit/all',
                {unit_name:unit_name,unit_text:unit_text,vk_id:vk_id,is_status:is_status},
                function (msg) {
                    console.log(msg)
                    if(msg.status=='1500'){
                        alert('直属单位名称')
                    }else if (msg.status=='1200'){
                        alert('直属单位')
                    }else if (msg.status=='5002'){
                        alert('添加失败')
                    }else{
                        alert('添加成功')
                    }
                }
            )
        })
    })
</script>