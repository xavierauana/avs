@extends("front.layouts.default")

@section('title')
    A Value Stay
@stop

@section('content')

    <router-view></router-view>
    <front-end-footer></front-end-footer>
@endsection

@section('scripts')
    <script src="/js/propertyCreate.js"></script>
@stop