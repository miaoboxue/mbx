<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="/js/layui/css/layui.css">
    <script src="/js/jquery-3.3.1.min.js"></script>


</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    
    @include('public.header')
    
    @include('public.left')
   
    <div class="layui-body">
        <!-- 内容主体区域 -->

        @yield('content')
    </div>
    
    @include('public.footer')
</div>
@section('footer')

<script src="/js/layui/layui.js"></script>
<script src="/js/layui/layui.all.js"></script>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
</script>
@show
</body>
</html>
