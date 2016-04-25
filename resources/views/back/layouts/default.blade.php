<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <meta name="is_guest" id="is_guest" content="{{ Auth::guest() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css">
    <link rel="stylesheet" href="/css/all.css">
    <style>
        body{
            background-color: grey;
        }
        .container-fluid{
            padding:0
        }
        body>.container-fluid>.container{
            background-color: white;
        }
    </style>
</head>
<body id="app">

    <div class="container">
        @yield("content")
    </div>


<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha256-KXn5puMvxCw+dAYznun+drMdG1IFl3agK0p/pqT9KAo= sha512-2e8qq0ETcfWRI4HJBzQiA3UoyFk6tbNyG+qSaIBZLyW9Xf3sWZHN/lxe9fTh1U45DpPf07yj94KsUHHWe4Yk1A==" crossorigin="anonymous"></script>

@yield('scripts')

</body>
</html>