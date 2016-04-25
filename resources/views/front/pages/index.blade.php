@extends("front.layouts.default")

@section('title')
    A Value Stay
@endsection

@section('content')
    <router-view></router-view>
    <front-end-footer></front-end-footer>
@endsection

@section('scripts')
    <script src="/js/app.js"></script>
@endsection