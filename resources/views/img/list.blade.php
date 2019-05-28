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
<script src="/js/layui/layui.js"></script>
<script>
    $(function(){
    layui.use('table', function(){
        var table = layui.table;

        //第一个实例
        table.render({
            elem: '#demo'
            ,width: 727
            ,url: '/img/table/' //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                ,{field: 'image', title: '图片', width:100}
                ,{field: 'is_status', title: '是否展示', width:90}
                ,{field: 'is_del', title: '是否删除', width:90}
                ,{field: 'add_time', title: '添加时间', width:180, sort: true}
                ,{fixed:'right',title:'操作',toolbar:'#barDemo',width:180}
            ]]
        });
        table.on('tool(test)',function(obj){
            if(obj.event=='edit'){
                var id=obj.data.id;
                location.href="/img/update/"+id;
            }else if(obj.event=="del"){
                var id=obj.data.id;
                layer.confirm('是否确认删除',{icon:3},function(index){
                    $.post(
                        '/img/delete',
                        {id:id},
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
</body>
</html>
@endsection