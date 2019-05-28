@extends('admin.layout')
@section('content')

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理员列表</title>
    <link rel="stylesheet" href="/js/layui/css/layui.css" media="all">
</head>
<body>

<table id="demo" lay-filter="test"></table>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<script src="/js/layui/layui.all.js"></script>
<script>
    $(function(){
    layui.use('table', function(){
        var table = layui.table;

        //第一个实例
        table.render({
            elem: '#demo'
            ,width:455
            ,url: '/admin/table/' //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {field: 'uid', title: 'ID', width:80, sort: true, fixed: 'left'}
                ,{field: 'uname', title: '用户名', width:80}
                ,{field: 'add_time', title: '添加时间', width:110, sort: true}
                ,{fixed:'right',title:'操作',toolbar:'#barDemo',width:180}
            ]]
        });
        table.on('tool(test)',function(obj){

            if(obj.event=='edit'){
                var uid=obj.data.uid
                location.href="/admin/update/"+uid;
            }else if(obj.event=="del"){
                var uid=obj.data.uid
                layer.confirm('是否确认删除',{icon:3},function(index){
                    $.post(
                        '/admin/delete',
                        {uid:uid},
                        function(msg){
                            layer.msg(msg.font,{icon:msg.code});
                            if(msg.code==1){
                                table.reload('demo');
                            }
                        },
                        'json'
                    )
                })
            }
        });
    });
    });


</script>
{{--<script>
    $(function(){
        layui.use(['table','layer'], function(){
            var table = layui.table;
            var layer = layui.layer;
            table.render({
                elem: '#demo'
                ,limit:3
                ,url: "{:url('admin/adminshow')}" //数据接口
                ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'admin_id', title: 'ID', width:150, sort: true, fixed: 'left'}
                    ,{field: 'admin_name', title: '姓名', width:150}
                    ,{field: 'admin_email', title: '邮箱',edit:'text', width:150, sort: true}
                    ,{field: 'admin_tel', title: '电话',edit:'text', width:150}
                    ,{field: 'create_time', title: '添加时间', width:200}
                    ,{fixed:'right',title:'操作',toolbar:'#barDemo',width:180}

                ]]
            })
            table.on('edit(table_edit)',function(obj){
                var value=obj.value
                    ,data=obj.data
                    ,field=obj.field;
                $.post(
                    "{:url('admin/adminupdate')}",
                    {value:value,field:field,admin_id:data.admin_id},
                    function(msg){
                        layer.msg(msg.font,{icon:msg.code});
                    },
                    'json'
                )
            })
            table.on('tool(table_edit)',function(obj){

                if(obj.event=='edit'){
                    var admin_id=obj.data.admin_id
                    location.href="{:url('admin/adminupdateshow')}?admin_id="+admin_id;
                }else if(obj.event=='giveRole'){
                    var admin_id=obj.data.admin_id
                    location.href="{:url('admin/giveRole')}?admin_id="+admin_id;
                }else if(obj.event=="del"){
                    var admin_id=obj.data.admin_id
                    layer.confirm('是否确认删除',{icon:3},function(index){
                        $.post(
                            "{:url('admin/admindel')}",
                            {admin_id:admin_id},
                            function(msg){
                                layer.msg(msg.font,{icon:msg.code});
                                if(msg.code==1){
                                    table.reload('demo');
                                }
                            },
                            'json'
                        )
                    })
                }
            })
        })
    })
</script>--}}
</body>
</html>
@endsection