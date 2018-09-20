@extends('admin.common.layout')
@section('title')
    {{ $title['title'] }}
@endsection
@section('head_files')
    <!-- Toastr style -->
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <!-- Gritter -->
    <link href="{{ asset(config('view.admin_static_path') . '/js/plugins/gritter/jquery.gritter.css') }}"
          rel="stylesheet">
    <!-- Validator -->
    <link rel="stylesheet" href="{{ asset(config('view.admin_static_path') . '/css/bootstrapValidator.css') }}"/>
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/dropzone/basic.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/jasny/jasny-bootstrap.min.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/codemirror/codemirror.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/switchery/switchery.css') }}"
          rel="stylesheet">
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/user/index') }}">{{ $title['title'] }}</a>
                </li>
                <li class="active">
                    <strong>{{ $title['sub_title'] }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{ $title['sub_title'] }}</h5>
                        <div class="ibox-tools">
                            <span class="btn btn-xs btn-warning" id="clear">
                                <i class="fa fa-eraser"></i>
                                清空
                            </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" id="add-user-form">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登录账号：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="account" placeholder="请输入用户登录账号">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="nickname" placeholder="请输入用户名">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户角色：</label>
                                <div class="col-sm-5">
                                    <select class="form-control m-b" name="role_id">
                                            <option selectd="selected">选择角色</option>
                                        @foreach($role_list as $role)
                                            <option value="{{ $role['id'] }}">{{ $role['role_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登录密码：</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" name="password" placeholder="请输入用户登录密码">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系方式：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="phone" placeholder="请输入用户联系方式">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">e-mail：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="e_mail" placeholder="请输入e-mail">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">账号头像：</label>
                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"><i
                                                    class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                    class="fileinput-filename"></span>
                                        </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">选择文件</span>
                                        <span class="fileinput-exists">更改</span>
                                        <input type="file" name="header_img">
                                    </span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                           data-dismiss="fileinput">删除</a>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">账号状态：</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" class="js-switch" checked/>
                                </div>
                                <input type="hidden" name="status"/>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="btn btn-white" id="add-user-cancel">取消</div>
                                    <div class="btn btn-primary" id="add-user-submit">保存</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <script src="{{ asset(config('view.admin_static_path') . '/js/bootstrapValidator.js') }}"></script>
    <!-- Jasny -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <!-- DROPZONE -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/dropzone/dropzone.js') }}"></script>
    <!-- CodeMirror -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/codemirror/mode/xml/xml.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/switchery/switchery.js') }}"></script>
    <script>
        $(document).ready(function () {
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {color: '#1AB394'});
            $('#add-user-form').bootstrapValidator({
                live: "submitted",
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
                                message: '用户账号不能为空！'
                            },
                            stringLength: {
                                min: 0,
                                max: 20,
                                message: '用户账号长度在20个字符以内！'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9_]+$/,
                                message: '用户名只能包含大写、小写、数字和下划线'
                            },
                            callback: {
                                message: '该账号已被使用',
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
                                    return !ajax_data;
                                }
                            }
                        }
                    },
                    nickname: {
                        validators: {
                            notEmpty: {
                                message: '用户名不能为空！'
                            },
                            stringLength: {
                                min: 0,
                                max: 12,
                                message: '用户名长度在12个字符以内！'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: '用户密码不能为空！'
                            },
                            stringLength: {
                                min: 6,
                                max: 20,
                                message: '用户密码长度在6-16个字符之间！'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            regexp: {
                                regexp: /^[-\+]?[0-9]+$/,
                                message: '电话格式不正确！'
                            }
                        }
                    },
                    e_mail: {
                        validators: {
                            emailAddress: {
                                message: '亲输入正确的邮箱地址！'
                            }
                        }
                    },
                    header_img: {
                        validators: {
                            callback: {
                                message: '请上传png、jpg、jpeg格式的图片！',
                                callback: function (value) {
                                    var type = value.substring(value.lastIndexOf('.') + 1);
                                    if (type != "png" && type != "jpeg" && type != "JPG" && type != "PNG" && type != "JPEG" && type != "jpg" && value != "") {
                                        return false;
                                    } else {
                                        return true;
                                    }
                                }
                            }
                        }
                    }
                }
            });
            $("#add-user-submit").click(function () {
                $('#add-user-form').bootstrapValidator('validate');
                var flag = $('#add-user-form').data('bootstrapValidator').isValid();
                setSwitchInInput(elem, "status");
                if (flag) {
                    var data = $("#add-user-form").serialize();
                    var type = "1";
                    var refresh = {
                        type: "1",
                        timeout: 2000,
                        url: "{{ url('admin/user/index') }}",
                    };
                    var confirmData = {
                        effect: "animated bounceInDown",
                        size: "sm",
                        action: "submit",
                        message: "你确定要提交吗？"
                    };
                    var ajaxData = {
                        url: "{{ url('admin/user/add') }}",
                        data: data
                    };
                    showAjaxMessage(type, confirmData, ajaxData, refresh);
                }
            });
            $("#clear").click(function () {
                $('#add-user-form').find("input[type=text]").val("");
                $('#add-user-form').find("input[type=file]").val("");
                $('#add-user-form').find("select[name=parent_id]").find("option:nth-child(2)").attr("selected", "selected");
                $('#add-user-form').find("input[name=status][type=radio]:first").prop("checked", true);
                $('#add-user-form').data('bootstrapValidator').resetForm(true);
            });
        });
    </script>
@endsection