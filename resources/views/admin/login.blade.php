<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <nav class="b_clear">
        <div class="nav_logo l_float">
            <img src="/images/logo.svg" alt="">
        </div>
        <div class="nav_link r_float">
            <ul>
                <li><a href="#">返回首页</a></li>
                <li><a href="#">关于我们</a></li>
                <li><a href="#">联系我们</a></li>
            </ul>
        </div>
    </nav>
</header>
<div class="container">
    <div class="login_body l_clear">
        <div class="login_form l_float">
            <div class="login_top">
                <img src="/images/logo_z.svg" alt="" class="">
            </div>
            <div class="login_con">
                <form action="">
                    <div>
                        <label for="user_name">用户名</label>
                        <input type="text" name="uname" id="uname" placeholder="账号/手机号/邮箱">
                        <img src="/images/icons/user.svg">
                        <p class="tips hidden">请检查您的账号</p>
                    </div>
                    <div>
                        <label for="user_pwd">密码</label>
                        <input type="password" name="pwd" id="passwd" placeholder="请输入账户密码">
                        <img src="/images/icons/lock.svg">
                        <p class="tips hidden">请检查您的密码</p>
                    </div>
                    <div class="b_clear button">
                        <button type="button" id="btn" >登&nbsp;&nbsp;录</button>
                        <a href="#" class="r_float">忘记密码？</a>
                    </div>
                </form>
            </div>
            <div class="login_con hidden">
                <div class="qr_code">
                    <img src="/images/qr.png" alt="">
                    <p>请使用微信扫码登录<br>仅支持已绑定微信的账户进行快速登录</p>
                </div>
            </div>
        </div>
        <div class="login_ad l_float" id="AdImg">
        </div>
    </div>
    <div class="footer">
        <p>Copyright © 2013-2018  <a href="#">创意星空</a></p>
    </div>
</div>
<script src="/js/login.js"></script>
<script src="/js/jquery-3.3.1.min.js"></script>
</body>
</html>
<script>
    $(function () {
        $("#btn").click(function () {
            var uname=$("#uname").val();
            var passwd = $("#passwd").val();
            $.post(
                '/admin/login',
                {uname:uname,pwd:passwd},
                function (msg) {
                    console.log(msg)
                    if (msg.status==602){
                        alert('账号不能为空')
                    } else if (msg.status==603){
                        alert('密码不能为空')
                    } else if (msg.status==604){
                        alert('账号或密码错误')
                    } else if (msg.status==200){
                        alert('登录成功')
                        location.href="/admin";
                    }
                }
            )
        })
    })
</script>