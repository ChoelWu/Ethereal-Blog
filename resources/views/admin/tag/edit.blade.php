@extends('admin.common.layout')
@section('title')
    index
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
                    <a href="index.html">{{ $title['title'] }}</a>
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
                        <h5>{{ $title['sub_title'] }}
                            <small>With custom checbox and radion elements.</small>
                        </h5>
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
            if (pre_status == "1") {
                setSwitchery(switchery, true);
            } else {
                setSwitchery(switchery, false);
            }

            function setSwitchery(switchElement, checkedBool) {
                if ((checkedBool && !switchElement.isChecked()) || (!checkedBool && switchElement.isChecked())) {
                    switchElement.setPosition(true);
                    switchElement.handleOnchange(true);
                }
            }

            $('#edit-tag-form').bootstrapValidator({
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
                            }
                        }
                    }
                }
            });
            $("#edit-tag-submit").click(function () {
                if (elem.checked) {
                    $('input[name="status"]').val('1');
                } else {
                    $('input[name="status"]').val('0');
                }
                var ajax_data;
                var form_data = new FormData($('#edit-tag-form')[0]);
                $('#edit-tag-form').bootstrapValidator('validate');
                var flag = $('#edit-tag-form').data('bootstrapValidator').isValid();
                if (flag) {
                    $.ajax({
                        type: "post",
                        url: "{{ url('admin/tag/edit') }}",
                        cache: false,
                        processData: false,
                        contentType: false,
                        async: false,
                        data: form_data,
                        dataType: "json",
                        success: function (data) {
                            ajax_data = data;
                        }
                    });
                    $('#message-modal-label').html("编辑标签");
                    if ('200' == ajax_data['status']) {
                        $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-check-square text-info"></i> ' + ajax_data['message'] + '</h3>');
                    } else {
                        $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-danger"></i> ' + ajax_data['message'] + '</h3>');
                    }
                    setTimeout(function () {
                        $("#message-modal").modal({
                            keyboard: false,
                            backdrop: false
                        });
                        $('#message-modal').modal('show');
                    }, 600);
                    if ('200' == ajax_data['status']) {
                        setTimeout(function () {
                            window.location.href = "{{ url('admin/tag/index') }}";
                        }, 2500);
                    } else {
                        setTimeout(function () {
                            $('#message-modal').modal('hide');
                        }, 2500);
                    }
                }

            });
            $("#clear").click(function () {
                $('#edit-tag-form').find("input[type=text]").val("");
                $('#edit-tag-form').data('bootstrapValidator').resetForm(true);
            });
        });
    </script>
@endsection