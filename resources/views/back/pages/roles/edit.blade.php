@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Edit Role: {{$role->label}}</h4>
        </div>
        <div class="panel-body">
            <form action="{{route('manager.roles.store')}}" method="patch" role="form">
                <input type='hidden' name='_token' value='{{csrf_token()}}'>

                <fieldset>
                    <legend>Role Info</legend>
                    @include("back.pages.roles.partials.form", compact('role'))
                </fieldset>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{route('manager.roles.index')}}" class="btn btn-primary">Back</a>
                <a href="{{route('manager.roles.permissions.index', $role->id)}}" class="btn btn-info">Permissions</a>
            </form>
        </div>
    </div>
@endsection