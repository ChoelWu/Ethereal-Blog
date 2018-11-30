@extends('admin.common.layout')
@section('title')
    index
@endsection
@section('content')
    <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">查看评论</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-success">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/comment/index') }}">{{ $title['title'] }}</a>
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
                            <span class="btn btn-xs btn-warning" id="rule-add">
                                <i class="fa fa-ban"></i>
                                敏感词
                            </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <form class="form-horizontal" id="index-comment-form" method="get">
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input placeholder="请输入文章标题进行搜索..." class="form-control" type="text"
                                               name="article_title"
                                               value="{{ $article_title }}">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary"> 搜索 </button>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        <input placeholder="请输入用户名进行搜索..." class="form-control" type="text"
                                               name="user"
                                               value="{{ $user }}">
                                        <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary"> 搜索 </button>
                                    </span>
                                    </div>
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
                                    <th>#</th>
                                    <th>所属文章</th>
                                    <th>发表用户</th>
                                    <th>赞</th>
                                    <th>置顶</th>
                                    <th class="col-lg-2">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $comment)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $comment->article->title }}</td>
                                        <td>{{ $comment->user->nickname }}</td>
                                        <td><i class="fa fa-thumbs-up"></i> {{ $comment->praise }}</td>
                                        <td>
                                            @if('0' == $comment->is_top)
                                                <button class="btn btn-xs btn-default stick-on-off"
                                                        data-id="{{ $comment->id }}" data-val="{{ $comment->is_top }}"
                                                        title="置顶">
                                                    <i class="fa fa-level-up"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-xs btn-warning stick-on-off"
                                                        data-id="{{ $comment->id }}" data-val="{{ $comment->is_top }}"
                                                        title="取消置顶">
                                                    <i class="fa fa-level-down"></i>
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-xs btn-info view-comment"
                                                    data-id="{{ $comment->id }}">
                                                <i class="fa fa-eye"></i> 查看
                                            </button>
                                            <span class="btn btn-xs btn-danger delete-comment"
                                                  data-id="{{ $comment->id }}">
                                                <i class="fa fa-times"></i> 删除
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                                {{ $list->appends(['user' => $user, 'article_title' => $article_title])->links() }}
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
            $(".delete-comment").click(function () {

                let comment_id = $(this).data("id");
                $('#action-modal').find('.modal-body').html('<h3><i class="fa fa-exclamation-triangle text-warning"></i> 是否要删除评论？</h3>');
                $('#action-modal').modal('show');
                $('#action-modal').find('.confirm').click(function () {
                    $('#action-modal').modal('hide');
                    $('#action-modal').on('hidden.bs.modal', function () {
                        $.get("{{ url('admin/comment/delete') }}", {"comment_id": comment_id}, function (data, status) {
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
            });
            $('.view-comment').click(function () {
                let url = "{{ url('admin/comment/view') }}";
                let id = $(this).data('id');
                let data = {id: id};
                $.get(url, data, function (data) {
                    if ('1' == data['type']) {
                        $('#myModal4').find('.modal-body .alert').html('<strong>' + data['user_name'] + '</strong> 在 <strong>《' + data['article_title'] + '》</strong> 中评论到：</strong><br>' + data['content']);
                        $('#myModal4').modal('show');
                    } else {
                        $('#myModal4').find('.modal-body .alert').html('<strong>' + data['user_name'] + '</strong> 在 <strong>《' + data['article_title'] + '》</strong> 中回复 <strong>' + data['response']['user_name'] + '</strong> ：</strong><br><br>' + data['content']);
                        let content = '<br><div class="panel panel-default"><div class="panel-heading"> <strong>' + data['response']['user_name'] + '</strong> 原评论：</div><div class="panel-body">' +
                            '<p>' + data['response']['content'] + '</p></div></div>';
                        $('#myModal4').find('.modal-body .alert').after(content);
                        $('#myModal4').modal('show');
                    }
                    console.log(data);
                });
            });
            $(".stick-on-off").click(function () {
                $.get("{{ url('admin/comment/stick') }}", {
                    "comment_id": $(this).data("id"),
                    "value": $(this).data("val")
                }, function () {
                    location.reload();
                });
            });
            $('#search-reset').click(function () {
                $('#index-comment-form div').find('input').val('');
                window.location.href = "{{ url('admin/comment/index') }}";
            });
        });
    </script>
@endsection