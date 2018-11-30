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
                        <form class="form-horizontal" id="edit-user-form">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">登录账号：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="account" value="{{ $user->account }}"
                                           placeholder="请输入用户登录账号">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户名：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="nickname"
                                           value="{{ $user->nickname }}" placeholder="请输入用户名">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">用户角色：</label>
                                <div class="col-sm-5">
                                    <select class="form-control m-b" name="role_id">
                                        <option value="" selectd="selected">选择角色</option>
                                        @foreach($role_list as $role)
                                            <option value="{{ $role['id'] }}">{{ $role['role_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group user-password">
                                <label class="col-sm-2 control-label">登录密码：</label>
                                <div class="col-sm-5">
                                    <button class="btn btn-primary btn-rounded pull-right" type="button"
                                            id="edit-password"><i class="fa fa-edit"></i> 更改
                                    </button>
                                    <input type="password" class="form-control hide" name="password"
                                           placeholder="请输入用户登录密码">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">联系方式：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="phone" value="{{ $user->phone }}"
                                           placeholder="请输入用户联系方式">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">e-mail：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="e_mail" value="{{ $user->e_mail }}"
                                           placeholder="请输入e-mail">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">账号头像：</label>
                                <div class="col-sm-5">
                                    <img alt="image" class="img-circle img-sm" id="header-img"
                                         src="@if('' != $user->header_img){{ asset($user->header_img) }}@else{{ asset(config('view.admin_static_path') . '/img/default_user.png') }}@endif">
                                    <button class="btn btn-primary btn-rounded pull-right" type="button"
                                            id="edit-header-img"><i class="fa fa-edit"></i> 更改
                                    </button>
                                    <div class="fileinput fileinput-new input-group hide" data-provides="fileinput"
                                         id="upload-header-img">
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
                                    <div class="btn btn-white" id="edit-user-cancel">取消</div>
                                    <div class="btn btn-primary" id="edit-user-submit">保存</div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $user->id }}">
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
            let elem = document.querySelector('.js-switch');
            let switchery = new Switchery(elem, {color: '#1AB394'});
            let pre_status = "{{ $user->status }}";
            setSwitch(pre_status, switchery);
            $('#edit-user-form').bootstrapValidator({
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
                                    let id = "{{ $user->id }}";
                                    let ajax_data = '';
                                    let token = "{{ csrf_token() }}";
                                    $.ajax({
                                        type: "post",
                                        url: "{{ url('admin/user/check_account') }}",
                                        data: {"account": value, action: "edit", id: id, _token: token},
                                        async: false,
                                        dataType: "json",
                                        success: function (data) {
                                            ajax_data = data;
                                        }
                                    });
                                    return ajax_data;
                                }
                            }
                        },
                    },
                    nickname: {
                        validators: {
                            notEmpty: {
                                message: '用户名不能为空！'
                            },
                            stringLength: {
                                min: 0,
                                max: 10,
                                message: '用户账号长度在10个字符以内！'
                            }
                        }
                    },
                    role_id: {
                        validators: {
                            notEmpty: {
                                message: '用户名不能为空！'
                            },
                        }
                    },
                    password: {
                        validators: {
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
                                message: '用户名只能包含大写、小写、数字和下划线'
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
                                    let type = value.substring(value.lastIndexOf('.') + 1);
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
            $("#edit-header-img").click(function () {
                $(this).addClass("hide");
                $("#header-img").addClass("hide");
                $("#upload-header-img").removeClass("hide");
            });
            $("#edit-password").click(function () {
                $(this).addClass("hide");
                $(".user-password input").removeClass("hide");
            });
            $("#edit-user-submit").click(function () {
                setSwitchInInput(elem, "status");
                $('#edit-user-form').bootstrapValidator('validate');
                let flag = $('#edit-user-form').data('bootstrapValidator').isValid();
                if (flag) {
                    let data = new FormData($('#edit-user-form')[0]);
                    let type = "1";
                    let refresh = {
                        type: "1",
                        timeout: 2000,
                        url: "{{ url('admin/user/index') }}",
                    };
                    let confirmData = {
                        effect: "animated bounceInDown",
                        size: "sm",
                        action: "submit",
                        message: "你确定要提交修改吗？"
                    };
                    let ajaxData = {
                        url: "{{ url('admin/user/edit') }}",
                        data: data
                    };
                    $.ajaxSetup({
                        cache: false,
                        processData: false,
                        contentType: false,
                    });
                    showAjaxMessage(type, confirmData, ajaxData, refresh);
                }
            });
            $("#clear").click(function () {
                $('#edit-user-form').find("input[type=text]").val("");
                $('#edit-user-form').find("input[type=file]").val("");
                $('#edit-user-form').find("select[name=parent_id]").find("option:nth-child(2)").attr("selected", "selected");
                $('#edit-user-form').find("input[name=status][type=radio]:first").prop("checked", true);
                $('#edit-user-form').data('bootstrapValidator').resetForm(true);
            });
        });
    </script>
@endsection