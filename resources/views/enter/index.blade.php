<!doctype html>
<html>
<head>
    <meta charset="gb2312">
    <title>政府网站模板</title>
    <meta name="Keywords" content="" >
    <meta name="Description" content="" >
    <link href="/css/index.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/js/modernizr.js"></script>
    <![endif]-->
    <!--[if IE 6]>
    <script  src="/js/png.js"></script>
    <script  src="/js/move.js"></script>
    <script type="text/javascript">
        EvPNG.fix('.logo');
    </script>
    <![endif]-->
</head>
<body>
<header>
    <div class="headtop">
        <div class="timer box">
            <span>
                <a onclick="javascript:window.external.addFavorite('/','')" href="/">加入收藏</a>
                | <a onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('/');" href="/">设为首页</a>
            </span>
            <script type="text/javascript" src="./js/timer.js">
            </script>
        </div>
    </div>
    <div class="logo box"></div>
    <nav id="nav" class="box">
        <ul>
            <?php foreach ($arr as $k=>$v){?>
                <li><a href="{{$v['nav_url']}}">{{$v['nav_name']}}</a></li>
            <?php }?>
            {{--<li><a href="#">机构设置</a></li>
            <li><a href="/policies">政策法规</a></li>
            <li><a href="list.html">纪检监察</a></li>
            <li><a href="new.html">政务公开</a></li>
            <li><a href="email.html">下载专区</a></li>
            <li><a href="gbook.html">办事指南</a></li>--}}
        </ul>
    </nav>
    <script src="/js/silder.js"></script>
</header>
<!--头部 end-->
<div class="banner box"><img src="/images/banner.jpg"></div>
<div class="box">
    <div class="news left">
        <h2><span class="more"><a href="/" target="_blank">更多..</a></span>新闻中心</h2>
        <ul>
            @foreach($img as $k => $v)
                <div class="pic_news left" style=""><img style=" height: 230px;width: 300px;" src="{{$v['image']}}"></div>
            @endforeach
            <div class="center_news right">
                <section class="c_n_top">
                    <h3>卫计局开展“道德讲堂”活动</h3>
                    <p>10月17日下午，卫计局举办了以“助人为乐”为主题的“道德讲堂”活动。使全体干部职工再一次受到了心灵的洗礼....[<a href="/" target="_blank">详情</a>]</p>
                </section>
                <ul>
                    @foreach($new_one as $k=>$v)
                    <li><a href="/" target="_blank">{{$v['new_name']}}<img src="/images/new.gif"></a></li>
                    @endforeach
                </ul>
            </div>
        </ul>
    </div>
    <div class="announce right">
        <h2><a href="/">通知公告</a></h2>
        <ul>
            <marquee onmouseover="this.stop()" onmouseout="this.start()" scrollamount="2" direction="up" height="240">
                @foreach($noti as $k=>$v)
                    <li><a href="{{$v['noti_url']}}" target="_blank">{{$v['noti_name']}}</a></li>
                @endforeach
            </marquee>
        </ul>
    </div>
    <div class="blank"></div>
    <div class="ad left"><img src="/images/ad01.jpg"></div>
    <div class="ad right"><img src="/images/ad02.jpg"></div>
    <div class="blank"></div>
        @foreach($new as $k=>$v)
        <div class="linews left">
            <h3><span><a href="/" class="more">更多..</a></span>{{$v['news_name']}}</h3>
                <ul>
                    @foreach($v['new_name'] as $kk=>$vv)
                        <li><a href="/new/info/{{$vv}}" target="_blank">{{$vv}}</a></li>
                    @endforeach
                </ul>
        </div>
        @endforeach
    <div class="blank"></div>
    <div class="ad"><img src="/images/ad03.jpg"></div>
    <div class="blank"></div>
    <div class="zhishu left">
        <h3>直属单位
            <ul id="tab">
                @foreach($vk as $k=>$v)
                    <li class="current"><a href="/">{{$v['vk_name']}}</a></li>
                @endforeach
            </ul>
        </h3>
        <section>
            <div id="content">
                @foreach($vk as $k=>$v)
                    <ul style="display:block;">
                        <div class="zs_pic left"> <img src="/images/newspic1.jpg"> </div>
                        <div class="zs_news right">
                            <ol>
                                @foreach($v['unit_name'] as $kk=>$vv)
                                <li>
                                    <a href="/unit/info/{{$vv}}" target="_blank">
                                        {{$vv}}
                                    </a>
                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </ul>
                @endforeach
                <ul>
                    {{--<div class="zs_pic left"> <img src="/images/newspic1.jpg"> </div>
                    <div class="zs_news right">
                        <ol>
                            <li><a href="/" target="_blank"><span>2013-12-24</span>中医院开展“全国高血压日”义诊宣传活动</a></li>
                            <li><a href="/" target="_blank"><span>2013-12-24</span>“五心”做好孕前优生健康检查工作</a></li>
                            <li><a href="/" target="_blank"><span>2013-12-24</span>实施“五项工程”帮助计生家庭发家致富</a></li>
                            <li><a href="/" target="_blank"><span>2013-12-24</span>喜摘全市人口计生统计与信息岗位技能竞赛桂冠</a></li>
                            <li><a href="/" target="_blank"><span>2013-12-24</span>卫计局开展“道德讲堂”活动</a></li>
                            <li><a href="/" target="_blank"><span>2013-12-24</span>美国挑起对华贸易争端 矛头直指</a></li>
                            <li><a href="/" target="_blank"><span>2013-12-24</span>中医院开展“全国高血压日”义诊宣传活动</a></li>
                        </ol>
                    </div>--}}
                </ul>
            </div>
        </section>
    </div>
    <div class="hd right">
        <h3>互动交流</h3>
        <ul>
            <li><a href="/">投诉举报</a></li>
            <li><a href="/">局长信箱</a></li>
        </ul>
    </div>
    <div class="blank"></div>
    <div class="links">
        <p>相关链接:</p>
        <ul>
            @foreach($link as $k=>$v)
                <li><a href="{{$v['link_url']}}">{{$v['link_name']}}</a></li>
            @endforeach
        </ul>
        <ul style="display:none">
            <a href="/"><img src="/images/ad01.jpg"></a><a href="/"><img src="/images/ad02.jpg"></a>
        </ul>
    </div>
</div>
<footer>
    <div class="footnav">
        <ul>
            <?php foreach ($arr as $k=>$v){?>
                <li><a href="index.html">{{$v['nav_name']}}</a></li>
            <?php }?>
        </ul>
    </div>
    <div class="copyright">
        <p>Copyright  2013 All Rights Reserved 版权所有 </p>
        <p>地址：广安市 联系电话：0826-2222222</p>
        <p>备案号：蜀11018486号</p>
    </div>

</footer>

</body>
</html>