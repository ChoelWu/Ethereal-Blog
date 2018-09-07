@extends('admin.common.layout')
@section('title')
    index
@endsection
@section('head_files')
    <link rel="stylesheet" href="{{ asset(config('view.admin_static_path') . '/css/bootstrapValidator.css') }}"/>
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>{{ $title['title'] }}</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('admin/module/index') }}">{{ $title['title'] }}</a>
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
                             <span class="btn btn-xs btn-primary" id="module-add">
                                <i class="fa fa-plus"></i> 新增
                            </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" id="module-form">
                            @csrf
                            @foreach($content_module as $module)
                                <div class="form-group">
                                    <div class="col-sm-3 col-sm-offset-2">
                                        <div class="input-group m-b">
                                            <div class="input-group-btn">
                                                <button data-toggle="dropdown" class="btn btn-white dropdown-toggle"
                                                        type="button">类型 <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">普通列表</a></li>
                                                    <li><a href="#">首页图</a></li>
                                                    <li><a href="#">广告标语</a></li>
                                                </ul>
                                            </div>
                                            <input class="form-control" type="text" value="{{ $module->name }}" name="name[]" placeholder="请输入变量名">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input class="form-control" type="text"  value="{{ $module->number }}" name="number[]" placeholder="请输入条数">
                                            <span class="input-group-addon">条</span>
                                            <input class="form-control" type="text" value="{{ $module->single_length }}" name="single_length[]" placeholder="请输入字数">
                                            <span class="input-group-addon">字</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control input-s-xs inline" name="nav_id" id="nav-selection">
                                            <option>选择导航</option>
                                            @foreach($nav_list as $item)
                                                <option value="{{ $item['id'] }}"
                                                        @if($module->nav_id == $item['id']) selected="selected" @endif>{{ $item['name'] }}</option>
                                                @foreach($item['children'] as $v)
                                                    <option value="{{ $v['id'] }}"
                                                            @if($module->nav_id == $v['id']) selected="selected" @endif>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;| - - {{ $v['name'] }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-5">
                                        <div class="btn btn-primary" id="module-submit">保存</div>
                                    </div>
                                </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('foot_files')
    <script src="{{ asset(config('view.admin_static_path') . '/js/bootstrapValidator.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/switchery/switchery.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#module-add').click(function () {
                var nav_list = JSON.parse('{!! $nav_json_list !!}');
                var option = '';
                for (var p in nav_list) {
                    option += '<option value="' + nav_list[p]['id'] + '">' + nav_list[p]['name'] + '</option>';
                    if (nav_list[p]['children'].length != 0) {
                        for (var q in nav_list[p]['children']) {
                            option += '<option value="' + nav_list[p]['children'][q]['id'] + '">| - - ' + nav_list[p]['children'][q]['name'] + '</option>';
                        }
                    }
                }
                var add_element = '<div class="form-group"><div class="col-sm-3 col-sm-offset-2"><div class="input-group m-b">' +
                    '<div class="input-group-btn"><button data-toggle="dropdown" class="btn btn-white dropdown-toggle" type="button">类型 <span class="caret">' +
                    '</span></button><ul class="dropdown-menu"><li><a href="#">普通列表</a></li><li><a href="#">首页图</a>' +
                    '</li><li><a href="#">广告标语</a></li></ul></div><input class="form-control" type="text" name="name[]" placeholder="请输入变量名">' +
                    '</div></div><div class="col-sm-3"><div class="input-group"><input class="form-control" type="text" name="number[]"  placeholder="请输入条数">' +
                    '<span class="input-group-addon">条</span><input class="form-control" type="text" name="single_length[]" placeholder="请输入字数"><span class="input-group-addon">字</span>' +
                    '</div></div><div class="col-sm-2"><select class="form-control input-s-xs inline" name="nav_id" id="nav-selection">' +
                    '<option>选择导航</option>' + option + '</select></div></div><div class="hr-line-dashed"></div>';
                $('div.hr-line-dashed:last').after(add_element);
            });
            $('#module-submit').click(function() {
                $('#module-form').attr("action", "{{ url('admin/module/add') }}").submit();
            });
        });
    </script>
@endsection