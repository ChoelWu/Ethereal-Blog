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
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/switchery/switchery.css') }}"
          rel="stylesheet">
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/tag/index') }}">{{ $title['title'] }}</a>
                </li>
                <li class="active">
                    <strong>{{ $title['sub_title'] }}</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
        </div>
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
                        <form class="form-horizontal" id="edit-tag-form">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标签名称：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value="{{ $tag->name }}"
                                           placeholder="请输入标签名">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标签状态：</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" class="js-switch" checked/>
                                </div>
                                <input type="hidden" name="status"/>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="btn btn-white" id="edit-tag-cancel">取消</div>
                                    <div class="btn btn-primary" id="edit-tag-submit">保存</div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $tag->id }}">
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
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {color: '#1AB394'});
            var pre_status = "{{ $tag->status }}";
            setSwitch(pre_status, switchery);
            $('#edit-tag-form').bootstrapValidator({
                live: "submitted",
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: '标签名称不能为空！'
                            },
                            stringLength: {
                                min: 1,
                                max: 20,
                                message: '标签名称在20个字符以内！'
                            },
                            callback: {
                                message: '已存在相同标签名的标签！',
                                callback: function (value) {
                                    var ajax_data;
                                    var id = "{{ $tag->id }}";
                                    var token = "{{ csrf_token() }}";
                                    $.ajax({
                                        type: "post",
                                        url: "{{ url('admin/tag/check_tag') }}",
                                        data: {id: id, _token: token, name: value, action: "edit"},
                                        async: false,
                                        timeout: 1000,
                                        dataType: "json",
                                        success: function (data) {
                                            ajax_data = data;
                                        }
                                    });
                                    return ajax_data;
                                }
                            }
                        }
                    }
                }
            });
            $("#edit-tag-submit").click(function () {
                setSwitchInInput(elem, "status");
                $('#edit-tag-form').bootstrapValidator('validate');
                var flag = $('#edit-tag-form').data('bootstrapValidator').isValid();
                if (flag) {
                    var data = $("#edit-tag-form").serialize();
                    var type = "1";
                    var refresh = {
                        type: "1",
                        timeout: 2000,
                        url: "{{ url('admin/tag/index') }}",
                    };
                    var confirmData = {
                        effect: "animated bounceInDown",
                        size: "sm",
                        action: "submit",
                        message: "你确定要提交修改吗？"
                    };
                    var ajaxData = {
                        url: "{{ url('admin/tag/edit') }}",
                        data: data
                    };
                    showAjaxMessage(type, confirmData, ajaxData, refresh);
                }
            });
            $("#clear").click(function () {
                $('#edit-tag-form').find("input[type=text]").val("");
                $('#edit-tag-form').data('bootstrapValidator').resetForm(true);
            });
        });
    </script>
@endsection