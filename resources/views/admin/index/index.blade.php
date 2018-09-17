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
@section('inputModal')
@endsection
@section('content')
    index
    <button id="text-btu">点我</button>
@endsection
@section('foot_files')
    <script>
        $(document).ready(function () {
            $('#text-btu').click(function () {
                var token = "{{ csrf_token() }}";
                var type = "2";
                var refresh = {type: "1", timeout: 3000};
                // var confirmData = {
                //     effect: "animated bounceInRight",
                //     size: "sm",
                //     action: "submit",
                //     message: "你确定要删除吗？"
                // };
                var confirmData = {
                    type: "warning",
                    title: "你确定要删除吗？",
                    message: ""
                };
                var ajaxData = {
                    url: "{{ url('admin/test') }}",
                    data: {id: '1', _token: token}
                };
                showAjaxMessage(type, confirmData, ajaxData, refresh);
            });
        });
    </script>
@endsection