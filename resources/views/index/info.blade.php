<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>内容页_杨青个人博客 - 一个站在web前端设计之路的女技术员个人博客网站</title>
    <meta name="keywords" content="个人博客,杨青个人博客,个人博客模板,杨青"/>
    <meta name="description" content="杨青个人博客，是一个站在web前端设计之路的女程序员个人网站，提供个人博客模板免费资源下载的个人原创网站。"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset(config('view.index_static_path') . '/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.index_static_path') . '/css/index.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.index_static_path') . '/css/m.css') }}" rel="stylesheet">
    <script src="{{ asset(config('view.index_static_path') . '/js/jquery-2.1.1.min.js') }}"></script>
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
        <div class="logo"><a href="{{ url('index/index') }}">杨青个人博客</a></div>
        <div id="mnav">
            <h2><span class="navicon"></span></h2>
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
    <h1 class="t_nav"><span>您现在的位置是：首页 > 慢生活 > 程序人生</span><a href="/" class="n1">网站首页</a><a href="/" class="n2">慢生活</a>
    </h1>
    <div class="infos">
        <div class="newsview">
            <h3 class="news_title">{{ $article->title }}</h3>
            <div class="news_author">
                <span class="au01">
                    <a href="mailto:dancesmiling@qq.com">杨青</a>
                </span>
                <span class="au02">{{ $article->publish_date }}</span>
                <span class="au03">
                    共<b> {{ $article->view_number }}</b>人围观
                </span>
            </div>
            <div class="tags">
                <a href="" target="_blank">个人博客</a>
                &nbsp; <a href="" target="_blank">小世界</a>
            </div>
            <div class="news_about">
                <strong>简介</strong>
                {!! $article->summary !!}
            </div>
            <div class="news_infos">
                {!! $article->content !!}
            </div>
        </div>
        <div class="share"></div>
        <div class="nextinfo">
            <p>上一篇：@if(empty($pre_article))<a href="">返回列表</a>@else<a href="{{ url('info/index') }}/{{  $pre_article->id }}">{{ $pre_article->title }}</a>@endif</p>
            <p>下一篇：@if(empty($next_article))<a href="">返回列表</a>@else<a href="{{ url('info/index') }}/{{  $next_article->id }}">{{ $next_article->title }}</a>@endif</p>
        </div>
        <div class="otherlink">
            <h2>相关文章</h2>
            <ul>
                <li><a href="/download/div/2018-04-22/815.html" title="html5个人博客模板《黑色格调》">html5个人博客模板《黑色格调》</a></li>
                <li><a href="/download/div/2018-04-18/814.html" title="html5个人博客模板主题《清雅》">html5个人博客模板主题《清雅》</a></li>
                <li><a href="/download/div/2018-03-18/807.html" title="html5个人博客模板主题《绅士》">html5个人博客模板主题《绅士》</a></li>
                <li><a href="/download/div/2018-02-22/798.html" title="html5时尚个人博客模板-技术门户型">html5时尚个人博客模板-技术门户型</a></li>
                <li><a href="/download/div/2017-09-08/789.html" title="html5个人博客模板主题《心蓝时间轴》">html5个人博客模板主题《心蓝时间轴》</a>
                </li>
                <li><a href="/download/div/2017-07-16/785.html" title="古典个人博客模板《江南墨卷》">古典个人博客模板《江南墨卷》</a></li>
                <li><a href="/download/div/2017-07-13/783.html" title="古典风格-个人博客模板">古典风格-个人博客模板</a></li>
                <li><a href="/download/div/2015-06-28/748.html" title="个人博客《草根寻梦》—手机版模板">个人博客《草根寻梦》—手机版模板</a></li>
                <li><a href="/download/div/2015-04-10/746.html" title="【活动作品】柠檬绿兔小白个人博客模板">【活动作品】柠檬绿兔小白个人博客模板</a></li>
                <li><a href="/jstt/bj/2015-01-09/740.html" title="【匆匆那些年】总结个人博客经历的这四年…">【匆匆那些年】总结个人博客经历的这四年…</a></li>
            </ul>
        </div>
        <div class="news_pl">
            <h2>文章评论</h2>
            <ul>
                <div class="gbko"></div>
            </ul>
        </div>
    </div>
    <div class="sidebar">
        <div class="search">
            <form action="/e/search/index.php" method="post" name="searchform" id="searchform">
                <input name="keyboard" id="keyboard" class="input_text" value="请输入关键字"
                       style="color: rgb(153, 153, 153);"
                       onfocus="if(value=='请输入关键字'){this.style.color='#000';value=''}"
                       onblur="if(value==''){this.style.color='#999';value='请输入关键字'}" type="text">
                <input name="show" value="title" type="hidden">
                <input name="tempid" value="1" type="hidden">
                <input name="tbname" value="news" type="hidden">
                <input name="Submit" class="input_submit" value="搜索" type="submit">
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
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/t02.jpg') }}"></i>展示的是首页html，博客页面布局格式简单，没有复杂的背景，色彩局部点缀，动态的幻灯片展示，切换卡，标...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-02-19/649.html" target="_blank"> 个人博客模板（2014草根寻梦）30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/b03.jpg') }}"></i>2014第一版《草根寻梦》个人博客模板简单、优雅、稳重、大气、低调。专为年轻有志向却又低调的草根站长设...
                    </p>
                </li>
                <li><b><a href="/download/div/2013-08-08/571.html" target="_blank">黑色质感时间轴html5个人博客模板30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/b04.jpg') }}"></i>黑色时间轴html5个人博客模板颜色以黑色为主色，添加了彩色作为网页的一个亮点，导航高亮显示、banner图片...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-09-18/730.html" target="_blank">情侣博客模板系列之《回忆》Html30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/b05.jpg') }}"></i>Html5+css3情侣博客模板，主题《回忆》，使用css3技术实现网站动画效果，主题《回忆》,分为四个主要部分，...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-04-17/661.html" target="_blank">黑色Html5个人博客模板主题《如影随形》30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/b06.jpg') }}"></i>014第二版黑色Html5个人博客模板主题《如影随形》，如精灵般的影子会给人一种神秘的感觉。一张剪影图黑白...
                    </p>
                </li>
                <li><b><a href="/jstt/bj/2015-01-09/740.html" target="_blank">【匆匆那些年】总结个人博客经历的这四年…30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/mb02.jpg') }}"></i>博客从最初的域名购买，到上线已经有四年的时间了，这四年的时间，有笑过，有怨过，有悔过，有执着过，也...
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
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/t02.jpg') }}"></i>展示的是首页html，博客页面布局格式简单，没有复杂的背景，色彩局部点缀，动态的幻灯片展示，切换卡，标...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-02-19/649.html" target="_blank"> 个人博客模板（2014草根寻梦）30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/b03.jpg') }}"></i>2014第一版《草根寻梦》个人博客模板简单、优雅、稳重、大气、低调。专为年轻有志向却又低调的草根站长设...
                    </p>
                </li>
                <li><b><a href="/download/div/2013-08-08/571.html" target="_blank">黑色质感时间轴html5个人博客模板30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/b04.jpg') }}"></i>黑色时间轴html5个人博客模板颜色以黑色为主色，添加了彩色作为网页的一个亮点，导航高亮显示、banner图片...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-09-18/730.html" target="_blank">情侣博客模板系列之《回忆》Html30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/b05.jpg') }}"></i>Html5+css3情侣博客模板，主题《回忆》，使用css3技术实现网站动画效果，主题《回忆》,分为四个主要部分，...
                    </p>
                </li>
                <li><b><a href="/download/div/2014-04-17/661.html" target="_blank">黑色Html5个人博客模板主题《如影随形》30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/b06.jpg') }}"></i>014第二版黑色Html5个人博客模板主题《如影随形》，如精灵般的影子会给人一种神秘的感觉。一张剪影图黑白...
                    </p>
                </li>
                <li><b><a href="/jstt/bj/2015-01-09/740.html" target="_blank">【匆匆那些年】总结个人博客经历的这四年…30...</a></b>
                    <p><i><img src="{{ asset(config('view.index_static_path') . '/images/images/mb02.jpg') }}"></i>博客从最初的域名购买，到上线已经有四年的时间了，这四年的时间，有笑过，有怨过，有悔过，有执着过，也...
                    </p>
                </li>
            </ul>
        </div>
        <div class="weixin">
            <h2 class="hometitle">官方微信</h2>
            <ul>
                <img src="{{ asset(config('view.index_static_path') . '/images/images/wx.jpg') }}">
            </ul>
        </div>
        <div class="ad" id="left_flow2"><img
                    src="{{ asset(config('view.index_static_path') . '/images/images/ad.jpg') }}"></div>
    </div>
</article>
<footer>
    <p>Design by <a href="/">杨青个人博客</a> <a href="/">蜀ICP备11002373号-1</a></p>
</footer>
<script src="{{ asset(config('view.index_static_path') . '/js/nav.js') }}"></script>
<script type="text/javascript">
    jQuery.noConflict();
    jQuery(function () {
        var elm = jQuery('#left_flow2');
        var startPos = jQuery(elm).offset().top;
        jQuery.event.add(window, "scroll", function () {
            var p = jQuery(window).scrollTop();
            jQuery(elm).css('position', ((p) > startPos) ? 'fixed' : '');

            jQuery(elm).css('top', ((p) > startPos) ? '0' : '');
        });
    });
</script>
</body>
</html>
