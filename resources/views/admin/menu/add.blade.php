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
                    <a href="{{ url('admin/menu/index') }}">{{ $title['title'] }}</a>
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
                        <form class="form-horizontal" id="add-menu-form">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">菜单名称：</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="name" placeholder="请输入菜单名称">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">父级菜单：</label>
                                <div class="col-sm-4">
                                    <select class="form-control m-b" name="parent_id">
                                        <option disabled="disabled">- - - - - - - - - - - - - - - - - - - - - - - - - -
                                            - - - - - - - - - - - - - - - -
                                        </option>
                                        <option value="0">顶级菜单</option>
                                        <option disabled="disabled">- - - - - - - - - - - - - - - - - - - - - - - - - -
                                            - - - - - - - - - - - - - - - -
                                        </option>
                                        @foreach($parent_menu_list as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                            @foreach($item['children'] as $v)
                                                <option value="{{ $v['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;| -
                                                    - {{ $v['name'] }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <span class="help-block m-b-none"><i
                                                class="fa fa-exclamation-triangle text-danger"></i> 请勿添加三级菜单</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">菜单序号：</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="sort" placeholder="请输入菜单序号">
                                    <span class="help-block m-b-none">菜单序号将用于对菜单的排序【默认：0】</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">菜单图标：</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="icon" placeholder="请输入菜单图标">
                                    <span class="help-block m-b-none">菜单图标请参照Font Awesome【默认：gear】</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">菜单地址：</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="url" placeholder="请输入菜单访问地址">
                                    <span class="help-block m-b-none">菜单地址请参照路由【示例：Admin/Menu/index】</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">菜单状态：</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" class="js-switch" checked/>
                                </div>
                                <input type="hidden" name="status"/>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="btn btn-white" id="add-menu-cancel">取消</div>
                                    <div class="btn btn-primary" id="add-menu-submit">保存</div>
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
    <!-- Switchery -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/switchery/switchery.js') }}"></script>
    <script>
        $(document).ready(function () {
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {color: '#1AB394'});
            $('#add-menu-form').bootstrapValidator({
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
                                message: '菜单名称不能为空！'
                            },
                            stringLength: {
                                min: 0,
                                max: 10,
                                message: '菜单名称长度在10个字符以内！'
                            }
                        }
                    },
                    parent_id: {
                        validators: {
                            callback: {
                                message: '请不要添加三级菜单！',
                                callback: function (value) {
                                    var ajax_data;
                                    $.ajax({
                                        type: "get",
                                        url: "{{ url('admin/menu/get_menu_level') }}",
                                        data: {"menu_id": value},
                                        async: false,
                                        dataType: "json",
                                        success: function (data) {
                                            ajax_data = data;
                                        }
                                    });
                                    return ajax_data <= 1;
                                }
                            }
                        }
                    },
                    sort: {
                        validators: {
                            regexp: {
                                regexp: /^[0-9]+$/,
                                message: '请输入数字作为菜单序号！'
                            },
                            stringLength: {
                                min: 0,
                                max: 10,
                                message: '序号长度在10以内！'
                            }
                        }
                    },
                    icon: {
                        validators: {
                            notEmpty: {
                                message: '菜单图标不能为空！'
                            }
                        }
                    },
                    url: {
                        validators: {
                            notEmpty: {
                                message: '菜单地址不能为空！'
                            }
                        }
                    }
                }
            });
            $("#add-menu-submit").click(function () {
                var ajax_data;
                $('#add-menu-form').bootstrapValidator('validate');
                var flag = $('#add-menu-form').data('bootstrapValidator').isValid();
                if (elem.checked) {
                    $('input[name="status"]').val('1');
                } else {
                    $('input[name="status"]').val('0');
                }
                if (flag) {
                    $.ajax({
                        type: "post",
                        url: "{{ url('admin/menu/add') }}",
                        data: $('#add-menu-form').serialize(),
                        async: false,
                        dataType: "json",
                        success: function (data) {
                            ajax_data = data;
                        }
                    });
                    $('#message-modal-label').html("添加菜单");
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
                            window.location.href = "{{ url('admin/menu/index') }}";
                        }, 2500);
                    } else {
                        setTimeout(function () {
                            $('#message-modal').modal('hide');
                        }, 2500);
                    }
                }
            });
            $("#clear").click(function () {
                $('#add-menu-form').find("input[type=text]").val("");
                $('#add-menu-form').find("select[name=parent_id]").find("option:nth-child(2)").attr("selected", "selected");
                $('#add-menu-form').find("input[name=status][type=radio]:first").prop("checked", true);
                $('#add-menu-form').data('bootstrapValidator').resetForm(true);
            });
        });
    </script>
@endsection