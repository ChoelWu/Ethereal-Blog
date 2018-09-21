@extends('admin.common.layout')
@section('title')
    index
@endsection
@section('head_files')
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/datapicker/datepicker3.css') }}"
          rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/switchery/switchery.css') }}"
          rel="stylesheet">
@endsection
@section('content')
    <div class="modal inmodal fade" id="publish-article-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-default">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">发布文章</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="publish-article-form">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-3 control-label">标题颜色：</label>
                            <div class="col-sm-5">
                                <input type="checkbox" class="js-switch" unchecked/>
                            </div>
                            <div id="cp2" class="col-sm-7 col-sm-offset-3 input-group colorpicker-component hidden"
                                 style="padding-left: 15px; padding-top:10px;">
                                <input type="text" class="form-control" name="title_color" value="#000000"
                                       disabled="disabled"/>
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
                                <input class="form-control" type="text" name="publish_date"
                                       value="{{ date('Y-m-d', time()) }}"
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
                        <input type="hidden" name="id" id="article-publish-id" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <div class="btn btn-primary" data-item-id="" id="submit-to-publish">提交</div>
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
                        <div class="row">
                            <form class="form-horizontal" id="index-article-form" method="get">
                                @csrf
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input placeholder="请输入文章标题/标题关键字进行搜索..." class="form-control" type="text"
                                               name="article_title"
                                               value="{{ $article_title }}">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary"> 搜索 </button>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-2 m-b-xs">
                                    <select class="form-control input-s-xs inline" name="nav_id" id="nav-selection">
                                        <option disabled="disabled">- - - - - - - - - - - - - - - - - -
                                        </option>
                                        <option value="">所有导航</option>
                                        <option disabled="disabled">- - - - - - - - - - - - - - - - - -
                                        </option>
                                        @foreach($nav_list as $item)
                                            <option value="{{ $item['id'] }}"
                                                    @if($nav_id == $item['id']) selected="selected" @endif>{{ $item['name'] }}</option>
                                            @foreach($item['children'] as $v)
                                                <option value="{{ $v['id'] }}"
                                                        @if($nav_id == $v['id']) selected="selected" @endif>&nbsp;&nbsp;&nbsp;&nbsp;|
                                                    -
                                                    - {{ $v['name'] }}</option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 m-b-xs">
                                    <select class="form-control input-s-xs inline" name="tag_id" id="tag-selection">
                                        <option value="">所有标签</option>
                                        @foreach($tag_list as $item)
                                            <option value="{{ $item['id'] }}"
                                                    @if($tag_id == $item['id']) selected="selected" @endif>{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 m-b-xs">
                                    <select class="form-control input-s-xs inline" name="status" id="status-selection">
                                        <option value="">所有状态</option>
                                        <option value="1" @if($status == '1') selected="selected" @endif>未发布</option>
                                        <option value="2" @if($status == '2') selected="selected" @endif>已发布</option>
                                    </select>
                                </div>
                                <div class="col-sm-1">
                                    <div class="input-group">
                                        <span id="search-reset" class="btn btn-warning"> 重置 </span>
                                    </div>
                                </div>
                            </form>
                        </div>
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
                                            <span class="btn @if('1' == $article->is_title_bold) btn-primary @else btn-default @endif btn-xs update-attribute"
                                                  data-action="bold" data-id="{{ $article->id }}"><i
                                                        class="fa fa-bold"></i></span>
                                            <span class="btn @if('1' == $article->is_title_italic) btn-primary @else btn-default @endif btn-xs update-attribute"
                                                  data-action="italic" data-id="{{ $article->id }}"><i
                                                        class="fa fa-italic"></i></span>
                                        </td>
                                        <td style=" @if('1' == $article->is_title_bold) font-weight: bold; @endif @if('1' == $article->is_title_italic) font-style: italic; @endif">
                                            {{ $article->title }}
                                        </td>
                                        <td>@if(!empty($article->nav)){{ $article->nav->name }}@endif</td>
                                        <td>@if(!empty($article->tag)){{ $article->tag->name }}@endif</td>
                                        <td>{{ $article->view_number }}</td>
                                        <td>{{ $article->publish_date }}</td>
                                        <td>
                                            @if('1' == $article->is_top)
                                                <span class="btn btn-warning btn-xs cancel-stick"
                                                      data-id="{{ $article->id }}" data-val="1" title="取消置顶">
                                                    <i class="fa fa-level-down"></i>
                                                </span>
                                            @else
                                                <span class="btn btn-default btn-xs cancel-stick"
                                                      data-id="{{ $article->id }}" data-val="0" title="置顶">
                                                    <i class="fa fa-level-up"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($article->status == '2')
                                                <button class="btn btn-xs btn-default cancel-publish-article"
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
                                {{ $list->appends(['article_title' => $article_title, 'nav_id' => $nav_id, 'tag_id' => $tag_id, 'status' => $status])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <!-- Switchery -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/switchery/switchery.js') }}"></script>
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
            var elem = document.querySelector('.js-switch');
            var switchery = new Switchery(elem, {color: '#1AB394'});
            elem.onchange = function () {
                if (elem.checked) {
                    $('#cp2 input').removeAttr('disabled');
                    $('#cp2').removeClass('hidden');
                } else {
                    $('#cp2').addClass('hidden');
                    $('#cp2 input').attr('disabled', 'disabled');
                }
            };
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
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/article/delete') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/article/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要删除文章吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $(".publish-article").click(function () {
                $('#article-publish-id').val('');
                $('#publish-article-form').find('input[name=publish_date]').val('');
                $('#publish-article-form').find('input[name=source]').val('');
                $('#publish-article-form').find('input[name=title_color]').val('');
                setSwitchery(switchery, false);
                $('#publish-article-form').find('input[name="title_color"]').attr('disabled', 'disabled');
                $('#publish-article-form').find("select").find("option:nth-child(0)").attr("selected", "selected");
                var id = $(this).data('id');
                $.get("{{ url('admin/article/publish') }}", {
                    id: id
                }, function (data) {
                    $('#publish-article-form').find('input[name="source"]').val(data['source']);
                    if (data['title_color'] != '') {
                        setSwitchery(switchery, true);
                        $('#publish-article-form').find('input[name="title_color"]').removeAttr('disabled');
                        $('#publish-article-form').find('input[name="title_color"]').val(data['title_color']);
                    }
                    // alert(data['publish_date']);
                    if (data['publish_date'] == null) {
                        $('#publish-article-form').find('input[name="publish_date"]').val("{{ date('Y-m-d', time()) }}");
                    } else {
                        $('#publish-article-form').find('input[name="publish_date"]').val(data['publish_date']);
                    }
                    $('#publish-article-form').find("select[name='nav_id']").find("option[value=" + data['nav_id'] + "]").attr("selected", "selected");
                    $('#publish-article-form').find("select[name='tag_id']").find("option[value=" + data['tag_id'] + "]").attr("selected", "selected");
                    $('#article-publish-id').val(id);
                });
                $('#publish-article-modal').modal('show');
            });
            $(".update-attribute").click(function () {
                var id = $(this).data("id");
                var action = $(this).data("action");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/article/update_attribute') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/article/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要更改文章属性吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token, action: action}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $(".cancel-stick").click(function () {
                var id = $(this).data("id");
                var value = $(this).data("val");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/article/stick') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/article/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要更改置顶状态吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token, value: value}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $('#submit-to-publish').click(function () {
                var data = $('#publish-article-form').serialize();
                var url = "{{ url('admin/article/publish') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/article/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要发布吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: data
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $('.cancel-publish-article').click(function () {
                var id = $(this).data("id");
                var token = "{{ csrf_token() }}";
                var url = "{{ url('admin/article/cancel_publish') }}";
                var type = "2";
                var refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/article/index') }}",
                };
                var confirmData = {
                    type: "warning",
                    title: "你确定要取消发布吗？",
                    message: ""
                };
                var ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $('#nav-selection').change(function () {
                $("#index-article-form").attr("action", "{{ url('admin/article/index') }}").submit();
            });
            $('#tag-selection').change(function () {
                $("#index-article-form").attr("action", "{{ url('admin/article/index') }}").submit();
            });
            $('#status-selection').change(function () {
                $("#index-article-form").attr("action", "{{ url('admin/article/index') }}").submit();
            });
            $('#search-reset').click(function () {
                $('#index-article-form div').find('input').val('');
                $('#nav-selection').find("option:nth-child(2)").attr("selected", "selected");
                $('#tag-selection').find("option:nth-child(1)").attr("selected", "selected");
                $('#status-selection').find("option:nth-child(1)").attr("selected", "selected");
                window.location.href = "{{ url('admin/article/index') }}";
            });
        });
    </script>
@endsection