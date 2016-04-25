@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Create A New Role</h4>
        </div>
        <div class="panel-body">
            <form action="{{route('manager.roles.store')}}" method="post" role="form">
                <input type='hidden' name='_token' value='{{csrf_token()}}'>

                <fieldset>
                    <legend>Role Info</legend>

                   @include("back.pages.roles.partials.form")
                </fieldset>
                <button type="submit" class="btn btn-success">Create</button>
            </form>
        </div>
    </div>
@endsection