<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSPINIA | 404 Error</title>
    <link href="{{ asset(config('view.admin_static_path') . '/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/style.css') }}" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="lock-word animated fadeInDown" style="margin-left: -580px;">
    <span class="first-word">WELCOME</span><span>SCREEN</span>
</div>
<div class="middle-box text-center lockscreen animated fadeInDown">
    <div>
        <div class="m-b-md">
            <img alt="image" class="img-circle circle-border" style="width: 100px; height: 100px;"
                 src="@if('' != $user->header_img){{ asset($user->header_img) }}@else{{ asset(config('view.admin_static_path') . '/img/male.png') }}@endif">
        </div>
        <h3>{{ $user->nickname }}</h3>
        <p style="line-height: 25px;">你已经在最近几天登录过本网站稍等几秒后我们将会为你进行跳转，，您也可及点击下方按钮进行跳转</p>
            <button id="index" class="btn btn-primary block full-width" >跳转首页</button>
    </div>
</div>
<!-- Mainly scripts -->
<script src="{{ asset(config('view.admin_static_path') . '/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset(config('view.admin_static_path') . '/js/bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#index').click(function() {
            window.location.href="{{ url('admin/index') }}";
        });
    });
</script>
</body>
</html>
