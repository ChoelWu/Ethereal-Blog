@extends('admin.common.layout')
@section('title')
    {{ $title['title'] }}
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
                        <h5>{{ $title['sub_title'] }}</h5>
                        <div class="ibox-tools">
                             <span class="btn btn-xs btn-primary" id="module-add">
                                <i class="fa fa-plus"></i> 新增
                            </span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal">
                            @csrf
                            @foreach($content_module as $module)
                                <div class="form-group">
                                    <div class="col-sm-2 col-sm-offset-2">
                                        <input type="text" class="form-control" value="{{ $module->name }}"
                                               name="name" placeholder="请输入变量名">
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input class="form-control" type="text" value="{{ $module->number }}"
                                                   name="number" placeholder="请输入条数">
                                            <span class="input-group-addon">条</span>
                                            <input class="form-control" type="text" value="{{ $module->single_length }}"
                                                   name="single_length" placeholder="请输入字数">
                                            <span class="input-group-addon">字</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control input-s-xs inline nav-selection" name="attach">
                                            <option value="0">选择数据来源</option>
                                            <option disabled="disabled"> - - - - - - - - - - - - - - - - - - -</option>
                                            <option value="1" @if($module->attach == '1') selected="selected" @endif>
                                                首页图
                                            </option>
                                            <option value="2" @if($module->attach == '2') selected="selected" @endif>
                                                广告标语
                                            </option>
                                            <option disabled="disabled"> - - - - - - - - - - - - - - - - - - -</option>
                                            @foreach($nav_list as $item)
                                                <option value="{{ $item['id'] }}"
                                                        @if($module->attach == $item['id']) selected="selected" @endif>|
                                                    - {{ $item['name'] }}</option>
                                                @foreach($item['children'] as $v)
                                                    <option value="{{ $v['id'] }}"
                                                            @if($module->attach == $v['id']) selected="selected" @endif>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;| - - {{ $v['name'] }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2 btn-action">
                                        <div class="btn btn-danger module-delete" data-id="{{ $module->id }}"><i
                                                    class="fa fa-times"></i> 删除
                                        </div>
                                        <div class="btn btn-primary module-submit" data-id="{{ $module->id }}"><i
                                                    class="fa fa-check"></i> 提交
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                            @endforeach
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-5">
                                    <div class="btn btn-info" onclick="location.reload();">一键还原</div>
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
    <!-- Switchery -->
    <script src="{{ asset(config('view.admin_static_path') . '/js/plugins/switchery/switchery.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#module-add').click(function () {
                let nav_list = JSON.parse('{!! $nav_json_list !!}');
                let option = '';
                for (let p in nav_list) {
                    option += '<option value="' + nav_list[p]['id'] + '">' + nav_list[p]['name'] + '</option>';
                    if (nav_list[p]['children'].length != 0) {
                        for (let q in nav_list[p]['children']) {
                            option += '<option value="' + nav_list[p]['children'][q]['id'] + '">| - - ' + nav_list[p]['children'][q]['name'] + '</option>';
                        }
                    }
                }
                let add_element = '<div class="form-group"><div class="col-sm-2 col-sm-offset-2">' +
                    '<input type="text" class="form-control" name="name" placeholder="请输入变量名"></div><div class="col-sm-3">' +
                    '<div class="input-group"><input class="form-control" type="text" name="number"  placeholder="请输入条数">' +
                    '<span class="input-group-addon">条</span><input class="form-control" type="text" name="single_length" placeholder="请输入字数">' +
                    '<span class="input-group-addon">字</span></div></div><div class="col-sm-2">' +
                    '<select class="form-control input-s-xs nav-selection" name="attach"><option value="0">选择数据来源</option>' +
                    '<option disabled="disabled"> - - - - - - - - - - - - - - - - - - - </option><option value="1">首页图</option>' +
                    '<option value="2">广告标语</option><option disabled="disabled"> - - - - - - - - - - - - - - - - - - - </option>' +
                    option + '</select></div><div class="col-sm-2 btn-action"><div class="btn btn-warning module-cancel"><i class="fa fa-mail-reply">' +
                    '</i> 撤销</div> <div class="btn btn-primary module-submit"><i class="fa fa-check"></i> 提交</div></div></div>' +
                    '<div class="hr-line-dashed"></div>';
                $('div.hr-line-dashed:last').after(add_element);
                console.log($('div.hr-line-dashed:last'));
            });
            $('.ibox-content').on("click", '.module-submit', function (e) {
                let element = $(e.target);
                let name = element.parent().siblings().find('input[name="name"]').val();
                let number = element.parent().siblings().find('input[name="number"]').val();
                let single_length = element.parent().siblings().find('input[name="single_length"]').val();
                let attach = element.parent().siblings().find('select[name="attach"]').val();
                let id = element.data('id');
                let token = "{{ csrf_token() }}";
                let url = "{{ url('admin/module/modify') }}";
                let type = "2";
                let refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/module/index') }}",
                };
                let confirmData = {
                    type: "warning",
                    title: "你确定要添加模块吗？",
                    message: ""
                };
                let ajaxData = {
                    url: url,
                    data: {
                        _token: token,
                        id: id,
                        name: name,
                        number: number,
                        single_length: single_length,
                        attach: attach
                    }
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $(".module-delete").click(function () {
                let id = $(this).data("id");
                let token = "{{ csrf_token() }}";
                let url = "{{ url('admin/module/delete') }}";
                let type = "2";
                let refresh = {
                    type: "1",
                    timeout: 2000,
                    url: "{{ url('admin/module/index') }}",
                };
                let confirmData = {
                    type: "warning",
                    title: "你确定要删除模块吗？",
                    message: ""
                };
                let ajaxData = {
                    url: url,
                    data: {id: id, _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
            $('.ibox-content').on("click", '.module-cancel', function (e) {
                let element = $(e.target);
                $(element).parent().parent().next().remove();
                $(element).parent().parent().remove();
            });
        });
    </script>
@endsection