<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>INSPINIA | Login</title>
    <link href="{{ asset(config('view.admin_static_path') . '/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/bootstrapValidator.css') }}" rel="stylesheet"/>
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">CMS</h1>
        </div>
        <h3>欢迎使用 CMS</h3>
        <p>精心打造的博客站点，扁平化的风格与人性化的设计将为您带来全新的体验</p>
        <p>红红火火恍恍惚惚</p>
        <form class="m-t" id="login-form">
            @csrf
            <div class="form-group">
                <input class="form-control" name="account" placeholder="请输入您的账号">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="请输入您的密码">
            </div>
            <div class="form-group">
                {!! Geetest::render('embed') !!}
            </div>
            <div class="form-group checkbox m-r-xs">
                <input type="checkbox" value="checked" name="remember_me">
                <label>
                    <small>记住我的账号</small>
                </label>
            </div>
            <div class="btn btn-primary block full-width m-b" id="confirm">登录</div>
            <a href="#">
                <small>忘记密码？</small>
            </a>
            <p class="text-muted text-center">
                <small>还没有账号？请联系管理员</small>
            </p>
        </form>
        <p class="m-t">
            <small>CMS base on Bootstrap 3 & laravel5.6 &copy; 2018</small>
        </p>
    </div>
</div>
<!-- Mainly scripts -->
<script src="{{ asset(config('view.admin_static_path') . '/js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset(config('view.admin_static_path') . '/js/bootstrap.min.js') }}"></script>
<script src="{{ asset(config('view.admin_static_path') . '/js/bootstrapValidator.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#login-form').bootstrapValidator({
            live: 'disabled',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                account: {
                    validators: {
                        notEmpty: {
                            message: '请输入登录账号！'
                        },
                        callback: {
                            message: '用户账号不存在！',
                            callback: function (value) {
                                var ajax_data;
                                $.ajax({
                                    type: "get",
                                    url: "{{ url('admin/auth/check_account') }}",
                                    data: {"account": value},
                                    async: false,
                                    dataType: "json",
                                    success: function (data) {
                                        ajax_data = data;
                                    }
                                });
                                return ajax_data;
                            }
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '请输入登录密码！'
                        }
                    }
                }
            }
        });
        $('#confirm').click(function () {
            $('#login-form').bootstrapValidator('validate');
            var flag = $('#login-form').data('bootstrapValidator').isValid();
            var ajax_data;
            if (flag) {
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type: "post",
                    url: "{{ url('admin/auth/login') }}",
                    data: $('#login-form').serialize(),
                    async: false,
                    dataType: "json",
                    success: function (data) {
                        ajax_data = data;
                    }
                });
                if (true == ajax_data['status']) {
                    $("#myModalLabel").html("<i class='glyphicon glyphicon-info-sign text-danger'></i> 登录成功");
                    $("div.modal-content div.modal-body").html("<h3 class='text-center'>" + ajax_data['message'] + "</span>");
                } else {
                    $("#myModalLabel").html("<i class='glyphicon glyphicon-info-sign text-danger'></i> 登录错误");
                    $("div.modal-content div.modal-body").html("<h3 class='text-center'>" + ajax_data['message'] + "</span>");
                }
                $("#myModal").modal("show");
                setTimeout(function () {
                    $("#myModal").modal("hide");
                }, 2000);
                if (true == ajax_data['status']) {
                    $('#myModal').on('hidden.bs.modal', function (e) {
                        window.location.href = "{{ url('admin/index') }}";
                    });
                }
            }
        });
    });
</script>
</body>
</html>