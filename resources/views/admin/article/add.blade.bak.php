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
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/datapicker/datepicker3.css') }}"
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
                            <div class="form-group">
                                <label class="col-sm-2 control-label">二级标题：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="name" value=""
                                           placeholder="请输入二级标题">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题属性：</label>
                                <div class="col-sm-5">
                                    <label class="checkbox-inline i-checks col-sm-3" style="padding-left: 0px;">
                                        <div class="icheckbox_square-green" style="position: relative;">
                                            <input value="option1" style="position: absolute; opacity: 0;"
                                                   type="checkbox">
                                            <ins class="iCheck-helper"
                                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins>
                                        </div>
                                        &nbsp;&nbsp;加粗
                                    </label>
                                    <label class="checkbox-inline i-checks col-sm-3" style="padding-left: 0px;">
                                        <div class="icheckbox_square-green" style="position: relative;">
                                            <input value="option2" style="position: absolute; opacity: 0;"
                                                   type="checkbox">
                                            <ins class="iCheck-helper"
                                                 style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255) none repeat scroll 0% 0%; border: 0px none; opacity: 0;"></ins>
                                        </div>
                                        &nbsp;&nbsp;倾斜
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题颜色：</label>
                                <div id="cp2" class="col-sm-2 input-group colorpicker-component"
                                     style="padding-left: 15px;">
                                    <input type="text" class="form-control" name="title_color" value="#DD0F20"/>
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章置顶：</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="i-checks">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">发布时间：</label>
                                <div class="input-group date col-sm-2" style="padding-left: 15px;">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control" type="text" value="{{ date('Y-m-d', time()) }}"
                                           id="datetimepicker" readonly="readonly">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属标签：</label>
                                <div class="col-sm-5">
                                    <select class="form-control m-b" name="tag_id">
                                        <option value="0">无分类</option>
                                        @foreach($tag_list as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属栏目：</label>
                                <div class="col-sm-5">
                                    <select class="form-control m-b" name="nav_id">
                                        <option disabled="disabled">- - - - - - - - - - - - - - - - - - - - - - - - - -
                                            - - - - - - - - - - - - - - - -
                                        </option>
                                        <option value="0">顶级栏目</option>
                                        <option disabled="disabled">- - - - - - - - - - - - - - - - - - - - - - - - - -
                                            - - - - - - - - - - - - - - - -
                                        </option>
                                        @foreach($nav_list as $nav)
                                            <option value="{{ $nav['id'] }}">{{ $nav['name'] }}</option>
                                            @foreach($nav['children'] as $v)
                                                <option value="{{ $v['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;| -
                                                    - {{ $v['name'] }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章来源：</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="source" value=""
                                           placeholder="请输入文章来源">
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章简述：</label>
                                <div class="col-sm-5">
                                    <textarea name="summary" class="form-control" id="" rows="5"></textarea>
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
                                    <textarea id="editor" rows="10"></textarea>
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
    <!-- iCheck -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- bootstrap-color-pick-->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <!-- SUMMERNOTE -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/language/summernote-zh-CN.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/language/bootstrap-markdown.zh.js') }}"></script>
    <!-- Bootstrap markdown -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/bootstrap-markdown/bootstrap-markdown.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/bootstrap-markdown/markdown.js') }}"></script>
    <script src="{{ asset(config('view.admin_static_path') . '/js/language/bootstrap-markdown.zh.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $(function () {
                $('#cp2').colorpicker();
            });
            $('#datetimepicker').datepicker({
                format: 'yyyy-mm-dd',
                weekStart: 1,
                todayBtn: 1,
                autoclose: true,
                forceParse: 0,
                showMeridian: 1,
                language: 'zh-cn',
                todayHighlight: true,
            });
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
        });
    </script>
@endsection

