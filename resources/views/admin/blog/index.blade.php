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
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>博客页面信息</h5>
                            </div>
                            <div class="ibox-content">
                                <form class="form-horizontal block1">
                                    @csrf
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">博客标题</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" placeholder="请填写博客标题" name="title"
                                                   value="{{ $list->title }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">博客页脚</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" placeholder="请填写博客页脚" name="footer"
                                                   value="{{ $list->footer }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">博客标语</label>
                                        <div class="col-lg-10">
                                            <input type="text" class="form-control" placeholder="请填写博客标语" name="slogan"
                                                   value="{{ $list->slogan }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-lg-offset-6">
                                            <div class="btn btn-sm btn-primary submit-info" data-block="1">确定</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>作者信息</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">基本信息</h3>
                                        <form class="block2">
                                            @csrf
                                            <div class="form-group">
                                                <label>作者名</label>
                                                <input type="text" placeholder="请填写博客作者昵称" class="form-control" name="user_name"
                                                       value="{{ $list->user_name }}">
                                            </div>
                                            <div class="form-group">
                                                <label>职业</label>
                                                <input type="text" placeholder="请填写博客作者职业" class="form-control" name="user_profession"
                                                       value="{{ $list->user_profession }}">
                                            </div>
                                            <div class="form-group">
                                                <label>个性动态</label>
                                                <input type="text" placeholder="请填写博客作者个性动态" class="form-control" name="user_announce"
                                                       value="{{ $list->user_announce }}">
                                            </div>
                                            <div class="form-group">
                                                <label>简介</label>
                                                <input type="text" placeholder="请填写博客作者作者简介" class="form-control" name="user_bak"
                                                       value="{{ $list->user_bak }}">
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-offset-6">
                                                    <div class="btn btn-sm btn-primary submit-info" data-block="2">
                                                        确定
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <h3>头像</h3>
                                        <p>点击上传头像</p>
                                        <p class="text-center" style="padding-top: 60px;">
                                            <a href=""><i class="fa fa-upload big-icon" aria-hidden="true"></i></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>社交信息</h5>
                    </div>
                    <div class="ibox-content ibox-heading">
                        <h3><i class="fa fa-comments-o"></i> 社交信息</h3>
                        <small>
                            <i class="fa fa-tim"></i> 你可以填写下面这些或其中一部分的社交信息，它们（它）将会公被开发布到你的微博
                        </small>
                    </div>
                    <div class="ibox-content">
                        <div class="feed-activity-list">
                            <form class="block3">
                                @csrf
                                <div class="feed-element">
                                    <div class="form-group">
                                        <label><i class="fa fa-qq"></i> 腾讯QQ</label>
                                        <input type="text" placeholder="请填入需要公开的QQ账号" name="user_QQ" value="{{ $list->user_QQ }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="feed-element">
                                    <div class="form-group">
                                        <label><i class="fa fa-envelope"></i> 电子邮箱</label>
                                        <input type="text" placeholder="请填入需要公开的电子邮箱账号" name="user_email" value="{{ $list->user_email }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="feed-element">
                                    <div class="form-group">
                                        <label><i class="fa fa-wechat"></i> 微信</label>
                                        <input type="text" placeholder="请填入需要公开的微信账号" name="user_wechat" value="{{ $list->user_wechat }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="feed-element">
                                    <div class="form-group">
                                        <label><i class="fa fa-weibo"></i> 微博</label>
                                        <input type="text" placeholder="请填入需要公开的微博账号" name="user_weibo" value="{{ $list->user_weibo }}"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="feed-element">
                                    <div class="form-group">
                                        <label><i class="fa fa-github"></i> GitHub</label>
                                        <input type="text" placeholder="请填入需要公开的GitHub账号" name="user_github"
                                               value="{{ $list->user_github }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group" style="margin-top: 10px;">
                                    <div class="col-lg-offset-6">
                                        <div class="btn btn-sm btn-primary submit-info" data-block="3">确定</div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <script>
        $(document).ready(function () {
            $(".submit-info").click(function () {
                    let block = $(this).data("block");
                    let data = $("form.block" + block).serialize();
                    let url = "{{ url('admin/blog/modify') }}";
                    $.post(url, data, function (result) {
                        console.log(result);
                    });
                }
            );
        });
    </script>
@endsection