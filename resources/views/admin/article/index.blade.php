@extends('admin.common.layout')
@section('title')
    index
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
                                    <th>#</th>
                                    <th>标题</th>
                                    <th style="width:10%;">所属栏目</th>
                                    <th style="width:10%;">所属标签</th>
                                    <th style="width:7%;">浏览数</th>
                                    <th style="width:7%;">是否置顶</th>
                                    <th style="width:14%;">发布日期</th>
                                    <th style="width:5%;">状态</th>
                                    <th style="width:12%;">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $article)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $article->title }} @if('' != $article->sub_title)
                                                —— {{ $article->sub_title }}@endif</td>
                                        <td>{{ $article->nav->name }}</td>
                                        <td>{{ $article->tag->name }}</td>
                                        <td>{{ $article->view_number }}</td>
                                        <td>@if('1' == $article->is_top) 是 @else 否 @endif</td>
                                        <td>{{ $article->publish_date }}</td>
                                        <td>
                                            @if($article->status == '2')
                                                <button class="btn btn-xs btn-default edit-article-status"
                                                        data-id="{{ $article->id }}" title="取消发布"><i
                                                            class="fa fa-share-square-o"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-xs btn-primary edit-article-status"
                                                        data-id="{{ $article->id }}" title="发布">
                                                    <i class="fa fa-share-square-o"></i>
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
    <script>
        $(document).ready(function () {
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
            $(".edit-article-status").click(function () {
                $.get("{{ url('admin/article/update_status') }}", {"article_id": $(this).data("id")}, function () {
                    location.reload();
                });
            });
        });
    </script>
@endsection