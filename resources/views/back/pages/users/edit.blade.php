@inject('RoleObject', 'App\Role')
@extends("front.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Create New User</h3>
        </div>
        <div class="panel-body">
            <form action="/admin/users/{{$user->id}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PUT">
                <fieldset>User Info</fieldset>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{$user->name}}">
                    {{$errors->first('name', '<p>:message</p>')}}
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="Email" value="{{$user->email}}">
                    {{$errors->first('email', '<p>:message</p>')}}

                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role[]" multiple>
                        @foreach($roles = $RoleObject::all() as $role)
                            <option value="{{$role->id}}" @if(in_array($role->id, $user->roles()->lists('id')->toArray())) selected @endif>{{$role->label}}</option>
                        @endforeach
                    </select>
                    {{$errors->first('role', '<p>:message</p>')}}

                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                    {{$errors->first('password', '<p>:message</p>')}}

                </div>

                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation:</label>
                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Password Confirmation">
                    {{$errors->first('password_confirmation', '<p>:message</p>')}}

                </div>

                <div class="form-group">
                    <input name="" type="submit" class="btn btn-success" value="Update">
                    <a href="/admin/users" class="btn btn-default"> Back </a>
                </div>
            </form>
        </div>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.16/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>
    <script></script>
@endsection