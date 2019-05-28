@extends('admin.layout')
@section('content')
    <input type="hidden" value="{{$arr['uid']}}" id="uid">
        <div class="layui-form-item">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-inline">
                <input type="text" name="uname" required value="{{$arr['uname']}}" id="username" lay-verify="required" placeholder="请输入账号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="passwd" value="{{$arr['passwd']}}" required id="pwd" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo" id="btn">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>

    <script>
        $(function () {
            //验证账号不能为空
            $("#username").blur(function () {
                var uname = $("#username").val();
                if (uname == ''){
                    alert("账号不能为空")
                }
            })
            //验证密码不能为空
            $("#pwd").blur(function () {
                var passwd = $("#pwd").val();
                if (passwd == ''){
                    alert("密码不能为空")
                }
            })
            $("#btn").click(function () {
                var uname = $("#username").val();
                var passwd =$("#pwd").val();
                var uid = $("#uid").val();
                $.post(
                    '/admin/updateall',
                    {uid:uid,uname:uname,passwd:passwd},
                    function (msg) {
                        console.log(msg)
                        if(msg.status=='1500'){
                            alert('账号不能为空')
                        }else if (msg.status=='1200'){
                            alert('密码不能为空')
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
@endsection