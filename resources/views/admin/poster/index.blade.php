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
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/dropzone/basic.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
    <link href="{{ asset(config('view.admin_static_path') . '/css/plugins/jasny/jasny-bootstrap.min.css') }}"
          rel="stylesheet">
@endsection
@section('content')
    <div class="modal inmodal" id="add-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">添加海报</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add-poster-form">
                        @csrf
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">海报标题：</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="title" placeholder="请输入海报标题">
                            </div>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">链接地址：</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="url" placeholder="请输入链接地址">
                            </div>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">内容简要：</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="" id="" rows="5"
                                          style="resize: vertical;"></textarea>
                            </div>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">账号头像：</label>
                            <div class="col-sm-8">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"><i
                                                class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-default btn-file">
                                        <span class="fileinput-new">选择文件</span>
                                        <span class="fileinput-exists">更改</span>
                                        <input type="file" name="header_img">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-default fileinput-exists"
                                       data-dismiss="fileinput">删除</a>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    <a href="{{ url('admin/role/index') }}">{{ $title['title'] }}</a>
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
            <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ $title['sub_title'] }}</h5>
                        <div class="ibox-tools">
                            <span class="btn btn-xs btn-primary" id="poster-add">
                                <i class="fa fa-plus"></i>
                                添加
                            </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table shoping-cart-table">
                                <tbody>
                                @foreach($list as $poster)
                                    <tr>
                                        <td width="200">
                                            <img src="{{ asset($poster['img']) }}" alt=""
                                                 width="200">
                                        </td>
                                        <td class="desc">
                                            <h3>
                                                <a href="{{ $poster->url }}" class="text-navy">{{ $poster->title }}</a>
                                            </h3>
                                            <p class="small">{{ $poster->summary }}</p>
                                            <div class="m-t-sm">
                                                <a href="#" class="text-warning"><i class="fa fa-level-up"></i> 置顶</a>
                                                |
                                                <a href="#" class="text-danger"><i class="fa fa-trash"></i> 删除</a>
                                                |
                                                <a href="#" class="text-success"><i class="fa fa-eye"></i> 禁用</a>
                                            </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <!-- Jasny -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <!-- DROPZONE -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/dropzone/dropzone.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#poster-add").click(function () {
                $('#add-modal').modal('show');
            });
        });
    </script>
@endsection