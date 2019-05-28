@extends('admin.layout')
@section('content')

        <div class="layui-form-item">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-inline">
                <input type="text" name="uname" required  id="username" lay-verify="required" placeholder="请输入账号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">手机号</label>
            <div class="layui-input-inline">
                <input type="text" name="tel" required  id="tel" lay-verify="required" placeholder="请输入手机号" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-inline">
                <input type="text" name="email" required  id="email" lay-verify="required" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="pwd" required id="pwd" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
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
            $("#tel").blur(function () {
                var tel = $("#tel").val();
                if (tel == ''){
                    alert("手机号不能为空")
                }
            })
            $("#email").blur(function () {
                var email = $("#email").val();
                if (email == ''){
                    alert("邮箱不能为空")
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
                var email = $("#email").val();
                var tel = $("#tel").val();
                var pwd =$("#pwd").val();
                $.post(
                    '/admin/all',
                    {uname:uname,pwd:pwd,tel:tel,email:email},
                    function (msg) {
                        console.log(msg)
                        if(msg.status=='1500'){
                            alert('账号不能为空')
                        }else if (msg.status=='1200'){
                            alert('密码不能为空')
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
@endsection