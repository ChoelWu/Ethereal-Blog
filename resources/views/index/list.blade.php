<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>学无止境_杨青个人博客 - 一个站在web前端设计之路的女技术员个人博客网站</title>
    <meta name="keywords" content="个人博客,杨青个人博客,个人博客模板,杨青"/>
    <meta name="description" content="杨青个人博客，是一个站在web前端设计之路的女程序员个人网站，提供个人博客模板免费资源下载的个人原创网站。"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset(config('view.index_static_path') . '/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.index_static_path') . '/css/index.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.index_static_path') . '/css/m.css') }}" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="{{ asset(config('view.index_static_path') . '/js/modernizr.js') }}"></script>
    <![endif]-->
    <script>
        window.onload = function () {
            var oH2 = document.getElementsByTagName("h2")[0];
            var oUl = document.getElementsByTagName("ul")[0];
            oH2.onclick = function () {
                var style = oUl.style;
                style.display = style.display == "block" ? "none" : "block";
                oH2.className = style.display == "block" ? "open" : ""
            }
        }
    </script>
</head>
<body>
<header>
    <div class="tophead">
        <div class="logo">
            <a href="{{ url('index/index') }}">杨青个人博客</a></div>
        <div id="mnav">
            <h2>
                <span class="navicon"></span>
            </h2>
            <ul>
                @foreach($nav_list as $nav)
                    <li><a href="{{ $nav['url'] }}">{{ $nav['name'] }}</a></li>
                @endforeach
            </ul>
        </div>
        <nav class="topnav" id="topnav">
            <ul>
                @foreach($nav_list as $nav)
                    <li><a href="{{ $nav['url'] }}">{{ $nav['name'] }}</a></li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>
<article>
    <h1 class="t_nav">
        <span>不要轻易放弃。学习成长的路上，我们长路漫漫，只因学无止境。 </span>
        <a href="/" class="n1">网站首页</a>
        <a href="/" class="n2">学无止境</a>
    </h1>
    <div class="blogs">
        <div class="mt20"></div>
        @foreach($article_list as $article)
            <li>
            <span class="blogpic">
                <a href="{{ url('info/index') }}/{{  $article->id }}">
                    <img src="{{ asset(config('view.index_static_path') . '/images/text02.jpg') }}">
                </a>
            </span>
                <h3 class="blogtitle">
                    <a href="{{ url('info/index') }}/{{  $article->id }}">{{  $article->title }}</a>
                </h3>
                <div class="bloginfo">
                    <p>{{  $article->summary }}</p>
                </div>
                <div class="autor">
                <span class="lm">
                    <a href="/" title="{{  $article->tag->name }}" target="_blank"
                       class="classname">{{  $article->tag->name }}</a>
                </span>
                    <span class="dtime">{{  $article->publish_date }}</span>
                    <span class="viewnum">浏览（<a>{{  $article->view_number }}</a>）</span>
                    <span class="readmore">
                    <a href="{{ url('info/index') }}/{{  $article->id }}">阅读原文</a>
                </span>
                </div>
            </li>
        @endforeach
        <div class="pagelist">
            {{ $article_list->links('vendor.pagination.default') }}
        </div>
    </div>
    <div class="sidebar">
        <div class="search">
            <form action="{{ url('list/index') }}" method="get" name="searchform" id="searchform">
                <input name="keyboard" id="keyboard" class="input_text" value="请输入关键字"
                       style="color: rgb(153, 153, 153);"
                       onfocus="if(value=='请输入关键字'){this.style.color='#000';value=''}"
                       onblur="if(value==''){this.style.color='#999';value='请输入关键字'}" type="text">
                <input class="input_submit" value="搜索" type="submit">
            </form>
        </div>
        <div class="lmnav">
            <h2 class="hometitle">栏目导航</h2>
            <ul class="navbor">
                <li><a href="#">关于我</a></li>
                <li><a href="share.html">模板分享</a>
                    <ul>
                        <li><a href="list.html">个人博客模板</a></li>
                        <li><a href="#">HTML5模板</a></li>
                    </ul>
                </li>
                <li><a href="list.html">学无止境</a>
                    <ul>
                        <li><a href="list.html">学习笔记</a></li>
                        <li><a href="#">HTML5+CSS3</a></li>
                        <li><a href="#">网站建设</a></li>
                    </ul>
                </li>
                <li><a href="#">慢生活</a></li>
            </ul>
        </div>
        <div class="paihang">
            <h2 class="hometitle">点击排行</h2>
            <ul>
                <li><b><a href="/download/div/2015-04-10/746.html" target="_blank">【活动作品】柠檬绿兔小白个人博客模板30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/t02.jpg') }}"></i>展示的是首页html，博客页面布局格式简单，没有复杂的背景，色彩局部点缀，动态的幻灯片展示，切换卡，标...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-02-19/649.html" target="_blank"> 个人博客模板（2014草根寻梦）30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/b03.jpg') }}"></i>2014第一版《草根寻梦》个人博客模板简单、优雅、稳重、大气、低调。专为年轻有志向却又低调的草根站长设...
                    </p>
                </li>
                <li><b><a href="/download/div/2013-08-08/571.html" target="_blank">黑色质感时间轴html5个人博客模板30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/b04.jpg') }}"></i>黑色时间轴html5个人博客模板颜色以黑色为主色，添加了彩色作为网页的一个亮点，导航高亮显示、banner图片...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-09-18/730.html" target="_blank">情侣博客模板系列之《回忆》Html30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/b05.jpg') }}"></i>Html5+css3情侣博客模板，主题《回忆》，使用css3技术实现网站动画效果，主题《回忆》,分为四个主要部分，...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-04-17/661.html" target="_blank">黑色Html5个人博客模板主题《如影随形》30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/b06.jpg') }}"></i>014第二版黑色Html5个人博客模板主题《如影随形》，如精灵般的影子会给人一种神秘的感觉。一张剪影图黑白...
                    </p>
                </li>
                <li><b><a href="/jstt/bj/2015-01-09/740.html" target="_blank">【匆匆那些年】总结个人博客经历的这四年…30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/mb02.jpg') }}"></i>博客从最初的域名购买，到上线已经有四年的时间了，这四年的时间，有笑过，有怨过，有悔过，有执着过，也...
                    </p>
                </li>
            </ul>
        </div>
        <div class="cloud">
            <h2 class="hometitle">标签云</h2>
            <ul>
                <a href="/">陌上花开</a> <a href="/">校园生活</a> <a href="/">html5</a> <a href="/">SumSung</a> <a
                        href="/">青春</a> <a href="/">温暖</a> <a href="/">阳光</a> <a href="/">三星</a><a href="/">索尼</a> <a
                        href="/">华维荣耀</a> <a href="/">三星</a> <a href="/">索尼</a>
            </ul>
        </div>
        <div class="paihang">
            <h2 class="hometitle">站长推荐</h2>
            <ul>
                <li><b><a href="/download/div/2015-04-10/746.html" target="_blank">【活动作品】柠檬绿兔小白个人博客模板30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/t02.jpg') }}"></i>展示的是首页html，博客页面布局格式简单，没有复杂的背景，色彩局部点缀，动态的幻灯片展示，切换卡，标...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-02-19/649.html" target="_blank"> 个人博客模板（2014草根寻梦）30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/b03.jpg') }}"></i>2014第一版《草根寻梦》个人博客模板简单、优雅、稳重、大气、低调。专为年轻有志向却又低调的草根站长设...
                    </p>
                </li>
                <li><b><a href="/download/div/2013-08-08/571.html" target="_blank">黑色质感时间轴html5个人博客模板30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/b04.jpg') }}"></i>黑色时间轴html5个人博客模板颜色以黑色为主色，添加了彩色作为网页的一个亮点，导航高亮显示、banner图片...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-09-18/730.html" target="_blank">情侣博客模板系列之《回忆》Html30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/b05.jpg') }}"></i>Html5+css3情侣博客模板，主题《回忆》，使用css3技术实现网站动画效果，主题《回忆》,分为四个主要部分，...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-04-17/661.html" target="_blank">黑色Html5个人博客模板主题《如影随形》30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/b06.jpg') }}"></i>014第二版黑色Html5个人博客模板主题《如影随形》，如精灵般的影子会给人一种神秘的感觉。一张剪影图黑白...
                    </p>
                </li>
                <li><b><a href="/jstt/bj/2015-01-09/740.html" target="_blank">【匆匆那些年】总结个人博客经历的这四年…30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/mb02.jpg') }}"></i>博客从最初的域名购买，到上线已经有四年的时间了，这四年的时间，有笑过，有怨过，有悔过，有执着过，也...
                    </p>
                </li>
            </ul>
        </div>
        <div class="weixin">
            <h2 class="hometitle">官方微信</h2>
            <ul>
                <img src="{{ asset(config('view.index_static_path') . '/images/wx.jpg') }}">
            </ul>
        </div>
    </div>
</article>
<footer>
    <p>Design by <a href="/">杨青个人博客</a> <a href="/">蜀ICP备11002373号-1</a></p>
</footer>
<script src="{{ asset(config('view.index_static_path') . '/js/nav.js') }}"></script>
</body>
</html>
