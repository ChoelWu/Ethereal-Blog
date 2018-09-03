@extends('admin.common.layout')
@section('title')
    index
@endsection
@section('head_files')
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/summernote/summernote.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/summernote/summernote-bs3.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/bootstrap-markdown/bootstrap-markdown.min.css') }}"
          rel="stylesheet">
    <!-- Validator -->
    <link rel="stylesheet" href="{{ asset(config('view.admin_static_path') . '/css/bootstrapValidator.css') }}"/>
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
                        <form class="form-horizontal" id="add-article-form">
                            @csrf
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章标题：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="title" placeholder="请输入文章标题">
                                </div>
                                <span class="text-danger">*</span>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章简述：</label>
                                <div class="col-sm-5">
                                    <textarea name="summary" class="form-control" id="" rows="5" style="resize:none" maxlength="150"></textarea>
                                    <span class="help-block m-b-none">请控制在150字符以内</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">编辑器类型：</label>
                                <div class="btn-group col-lg-10">
                                    <div class="btn btn-primary editor-selector" data-type="rich-text">富文本</div>
                                    <div class="btn btn-white editor-selector" data-type="markdown">MarkDown</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章内容：</label>
                                <div class="col-lg-8" id="editor-outer">
                                    <textarea id="editor" name="content" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <div class="btn btn-white" id="cancel-article-cancel">取消</div>
                                    <div class="btn btn-primary" id="add-article-submit">保存</div>
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
    <!-- SUMMERNOTE -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/language/summernote-zh-CN.js') }}"></script>
    <!-- Bootstrap markdown -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/bootstrap-markdown/bootstrap-markdown.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/bootstrap-markdown/markdown.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/language/bootstrap-markdown.zh.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/language/bootstrap-markdown.zh.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#editor').summernote({
                height: 300,
                focus: false,
                lang: 'zh-CN',
                placeholder: '请自此输入文章内容...'
            });
            $('.editor-selector').click(function () {
                $('.editor-selector').addClass('btn-white');
                $('.editor-selector').removeClass('btn-primary');
                $(this).removeClass('btn-white');
                $(this).addClass('btn-primary');
                $('#editor').remove();
                $('#editor-outer').html('<textarea id="editor" rows="10"></textarea>');
                var type = $(this).data('type');
                if ('rich-text' == type) {
                    $('#editor').summernote({
                        height: 300,
                        focus: true,
                        lang: 'zh-CN',
                        placeholder: '请自此输入文章内容...'
                    });
                } else if ('markdown' == type) {
                    $('#editor').summernote('destroy');  //销毁summernote
                    $("#editor").markdown({
                        autofocus: true,
                        savable: false,
                        height: 300,
                        language: 'zh',
                        fullscreen: false
                    })
                }
            });
            $('#add-article-form').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    title: {
                        validators: {
                            notEmpty: {
                                message: '文章标题不能为空！'
                            }
                        }
                    }
                }
            });
            $('#add-article-submit').click(function() {
                var ajax_data;
                $('#add-article-form').bootstrapValidator('validate');
                var flag = $('#add-article-form').data('bootstrapValidator').isValid();
                if (flag) {
                    $.ajax({
                        type: "post",
                        url: "{{ url('admin/article/add') }}",
                        data: $('#add-article-form').serialize(),
                        async: false,
                        dataType: "json",
                        success: function (data) {
                            ajax_data = data;
                        }
                    });
                    $('#message-modal-label').html("添加文章");
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
                            window.location.href = "{{ url('admin/article/index') }}";
                        }, 2500);
                    } else {
                        setTimeout(function () {
                            $('#message-modal').modal('hide');
                        }, 2500);
                    }
                }
            });
        });
    </script>
@endsection

