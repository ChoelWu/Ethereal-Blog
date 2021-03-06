@extends('admin.common.layout')
@section('title')
    {{ $title['sub_title'] }}
@endsection
@section('head_files')
    <!-- Toastr style -->
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <!-- Gritter -->
    <link href="{{ asset(config('view.admin_static_path') . '/js/plugins/gritter/jquery.gritter.css') }}"
          rel="stylesheet">
    <!-- Validator -->
    <link rel="stylesheet" href="{{ asset(config('view.admin_static_path') . '/css/bootstrapValidator.css') }}"/>
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/switchery/switchery.css') }}"
          rel="stylesheet">
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/rule/index') }}">{{ $title['title'] }}</a>
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
                        <form class="form-horizontal" id="edit-role-form">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">角色名：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="role_name"
                                           value="{{ $role->role_name }}"
                                           placeholder="请输入角色名">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">角色状态：</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" class="js-switch" checked/>
                                </div>
                                <input type="hidden" name="status"/>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="btn btn-white" id="edit-role-cancel">取消</div>
                                    <div class="btn btn-primary" id="edit-role-submit">保存</div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $role->id }}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <script src="{{ asset(config('view.admin_static_path') . '/js/bootstrapValidator.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/switchery/switchery.js') }}"></script>
    <script>
        $(document).ready(function () {
            let elem = document.querySelector('.js-switch');
            let switchery = new Switchery(elem, {color: '#1AB394'});
            let pre_status = "{{ $role->status }}";
            setSwitch(pre_status, switchery);
            $('#edit-role-form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    role_name: {
                        validators: {
                            notEmpty: {
                                message: '角色名称不能为空！'
                            },
                            stringLength: {
                                min: 0,
                                max: 20,
                                message: '角色名称在20个字符以内！'
                            }
                        }
                    }
                }
            });
            $("#edit-role-submit").click(function () {
                setSwitchInInput(elem, "status");
                $('#edit-role-form').bootstrapValidator('validate');
                let flag = $('#edit-role-form').data('bootstrapValidator').isValid();
                if (flag) {
                    let data = $("#edit-role-form").serialize();
                    let type = "1";
                    let refresh = {
                        type: "1",
                        timeout: 2000,
                        url: "{{ url('admin/role/index') }}",
                    };
                    let confirmData = {
                        effect: "animated bounceInDown",
                        size: "sm",
                        action: "submit",
                        message: "你确定要提交修改吗？"
                    };
                    let ajaxData = {
                        url: "{{ url('admin/role/edit') }}",
                        data: data
                    };
                    showAjaxMessage(type, confirmData, ajaxData, refresh);
                }
            });
            $("#clear").click(function () {
                $('#edit-role-form').find("input[type=text]").val("");
                $('#edit-role-form').find("input[name=status][type=radio]:first").prop("checked", true);
                $('#edit-role-form').data('bootstrapValidator').resetForm(true);
            });
        });
    </script>
@endsection