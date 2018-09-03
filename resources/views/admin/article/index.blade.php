@extends('admin.common.layout')
@section('title')
    index
@endsection
@section('head_files')
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/datapicker/datepicker3.css') }}"
          rel="stylesheet">
@endsection
@section('content')
    <div class="modal inmodal fade" id="publish-article-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-default">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">角色授权</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add-article-form">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">标题颜色：</label>
                            <div id="cp2" class="col-sm-7 input-group colorpicker-component"
                                 style="padding-left: 15px;">
                                <input type="text" class="form-control" name="title_color" value="#000000"/>
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">发布时间：</label>
                            <div class="input-group date col-sm-7" style="padding-left: 15px;">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                <input class="form-control" type="text" value="{{ date('Y-m-d', time()) }}"
                                       id="datetimepicker" readonly="readonly">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">所属标签：</label>
                            <div class="col-sm-7">
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
                            <label class="col-sm-3 control-label">所属栏目：</label>
                            <div class="col-sm-7">
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
                            <label class="col-sm-3 control-label">文章来源：</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="source" value=""
                                       placeholder="请输入文章来源">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <div class="btn btn-primary" data-item-id="" id="submit-rules">提交</div>
                </div>
            </div>
        </div>
    </div>
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
                        <span class="btn btn-xs btn-primary" id="article-add">
                            <i class="fa fa-plus"></i>
                            新增
                        </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th style="width:2%;">#</th>
                                    <th colspan="2">标题</th>
                                    <th style="width:10%;">所属栏目</th>
                                    <th style="width:10%;">所属标签</th>
                                    <th style="width:7%;">浏览数</th>
                                    <th style="width:8%;">发布日期</th>
                                    <th style="width:4%;">置顶</th>
                                    <th style="width:6%;">发布</th>
                                    <th style="width:10%;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $article)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td style="width:5%;">
                                            @if('1' == $article->is_title_bold)
                                                <span class="btn btn-primary btn-xs"><i class="fa fa-bold"></i></span>
                                            @else
                                                <span class="btn btn-default btn-xs"><i class="fa fa-bold"></i></span>
                                            @endif

                                            @if('1' == $article->is_title_italic)
                                                <span class="btn btn-primary btn-xs"><i class="fa fa-italic"></i></span>
                                            @else
                                                <span class="btn btn-default btn-xs"><i class="fa fa-italic"></i></span>
                                            @endif
                                        </td>
                                        <td>{{ $article->title }} @if('' != $article->sub_title)
                                                —— {{ $article->sub_title }}@endif</td>
                                        <td>@if(!empty($article->nav)){{ $article->nav->name }}@endif</td>
                                        <td>@if(!empty($article->tag)){{ $article->tag->name }}@endif</td>
                                        <td>{{ $article->view_number }}</td>
                                        <td>{{ $article->publish_date }}</td>
                                        <td>
                                            @if('1' == $article->is_top)
                                                <span class="btn btn-warning btn-xs" title="取消置顶">
                                                    <i class="fa fa-level-down"></i>
                                                </span>
                                            @else
                                                <span class="btn btn-default btn-xs" title="置顶">
                                                    <i class="fa fa-level-up"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($article->status == '2')
                                                <button class="btn btn-xs btn-default publish-article"
                                                        data-id="{{ $article->id }}"><i
                                                            class="fa fa-mail-reply"></i> 取消
                                                </button>
                                            @else
                                                <button class="btn btn-xs btn-primary publish-article"
                                                        data-id="{{ $article->id }}">
                                                    <i class="fa fa-mail-forward"></i> 发布
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="btn btn-xs btn-primary edit-article"
                                                  data-id="{{ $article->id }}">
                                                <i class="fa fa-edit"></i> 編輯
                                            </span>
                                            <span class="btn btn-xs btn-danger delete-article"
                                                  data-id="{{ $article->id }}">
                                                <i class="fa fa-times"></i> 删除
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $list->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <!-- Peity -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Peity -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/demo/peity-demo.js') }}"></script>
    <!-- bootstrap-color-pick-->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script>
        $(document).ready(function () {
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
            $("#article-add").click(function () {
                window.location.href = "{{ url('admin/article/add') }}";
            });
            $(".edit-article").click(function () {
                window.location.href = "{{ url('admin/article/edit') }}/" + $(this).data("id");
            });
            $(".delete-article").click(function () {
                var is_disabled = $(this).attr("disabled");
                if (is_disabled != "disabled") {
                    var article_id = $(this).data("id");
                    $('#action-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-warning"></i> 是否要删除文章？</h3>');
                    $('#action-modal').modal('show');
                    $('#action-modal').find('.confirm').click(function () {
                        $('#action-modal').modal('hide');
                        $('#action-modal').on('hidden.bs.modal', function () {
                            $.get("{{ url('admin/article/delete') }}", {"article_id": article_id}, function (data, status) {
                                $('#message-modal-label').html(data['title']);
                                if ('success' == status) {
                                    if ('200' == data['status']) {
                                        $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-check-square text-info"></i> ' + data['message'] + '</h3>');
                                    } else {
                                        $('#message-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-danger"></i> ' + data['message'] + '</h3>');
                                    }
                                }
                            });
                        });
                        setTimeout(function () {
                            $("#message-modal").modal({
                                keyboard: false,
                                backdrop: false
                            });
                            $('#message-modal').modal('show');
                        }, 600);
                        setTimeout(function () {
                            location.reload();
                        }, 2500);
                    });
                }
            });
            $(".publish-article").click(function () {
                $('#publish-article-modal').modal('show');
            });
        });
    </script>
@endsection