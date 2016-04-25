@extends("front.layouts.default")

@section('title')
    A Value Stay
@stop

@section('content')
    <components :is="currentView" :query="queryObject"></components>
    <front-end-footer></front-end-footer>
@endsection

@section('scripts')
    <script src="/js/propertyEdit.js"></script>
@stop