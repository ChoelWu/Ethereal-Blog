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
        <div class="col-sm-4">
            <h2>请求被终止</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/index') }} ">控制台首页</a>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content">
        <div class="middle-box text-center animated fadeInRightBig">
            <h2 class="font-bold">对不起，您没有访问权限</h2>
            <br class="error-desc">
            您没有该功能的访问权限，请联系管理员或者平台维护人员对本问题进行处理。
            <br/><a href="javascript:history.go(-1);" class="btn btn-primary m-t">返回</a>
        </div>
    </div>
    </div>
@endsection
@section('foot_files')
@endsection