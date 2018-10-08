@extends('admin.common.layout')
@section('title')
    {{ $title['title'] }}
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
    <link rel="stylesheet" href="{{ asset(config('view.admin_static_path') . '/css/plugins/jasny/jasny-bootstrap.min.css') }}"/>
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/article/index') }}">{{ $title['title'] }}</a>
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
                                <label class="col-sm-2 control-label">账号头像：</label>
                                <div class="col-sm-5">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                            <span class="fileinput-filename"></span>
                                        </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">选择文件</span>
                                            <span class="fileinput-exists">更改</span>
                                            <input type="file" name="upload_file">
                                        </span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                           data-dismiss="fileinput">删除</a>
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章简述：</label>
                                <div class="col-sm-5">
                                    <textarea name="summary" class="form-control" id="" rows="5" style="resize:none"
                                              maxlength="150"></textarea>
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
    <!-- Jasny -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
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
            {{--$('#add-article-submit').click(function () {--}}
                {{--$('#add-article-form').bootstrapValidator('validate');--}}
                {{--var flag = $('#add-article-form').data('bootstrapValidator').isValid();--}}
                {{--if (flag) {--}}
                    {{--var data = $("#add-article-form").serialize();--}}
                    {{--var type = "1";--}}
                    {{--var refresh = {--}}
                        {{--type: "1",--}}
                        {{--timeout: 2000,--}}
                        {{--url: "{{ url('admin/article/index') }}",--}}
                    {{--};--}}
                    {{--var confirmData = {--}}
                        {{--effect: "animated bounceInDown",--}}
                        {{--size: "sm",--}}
                        {{--action: "submit",--}}
                        {{--message: "你确定要提交吗？"--}}
                    {{--};--}}
                    {{--var ajaxData = {--}}
                        {{--url: "{{ url('admin/article/add') }}",--}}
                        {{--data: data--}}
                    {{--};--}}
                    {{--showAjaxMessage(type, confirmData, ajaxData, refresh);--}}
                {{--}--}}
            {{--});--}}
        });
    </script>
@endsection

