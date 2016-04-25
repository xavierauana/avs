@extends("front.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">All User
                <a href="/admin/users/create" class="btn btn-sm btn-success pull-right" style="margin-top: -6px; color:white"
                        >Create New User
                </a>
            </h3>
        </div>
        <table class="table table-responsive">
            <thead>
            <th>Name</th>
            <th>Email</th>
            <th></th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td style="min-width:150px">
                        <div class="btn-group btn-group-sm">
                            <a href="/admin/users/{{$user->id}}/edit" class="btn btn-sm btn-info"
                                   >Edit
                            </a>
                            <button class="btn btn-sm  btn-danger" @click.prevent="clickDeleteButton({{$user->id}}, $event)">Delete</button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.16/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>
    <script>
        new Vue({
            el: "#app",
            methods: {
                clickDeleteButton: function(userId, e){
                    if(confirm('Are you sure you want to delete?')){
                        var uri = '/admin/users/'+userId+'/delete';
                        this.$http.delete(uri, null , {
                            headers:{
                                'X-CSRF-TOKEN': document.querySelector('meta#csrf-token').getAttribute('content')
                            }
                        }).then(function(response){
                            if(response.ok){
                                e.target.parentNode.parentNode.parentNode.remove()
                            }
                        });
                    }
                }
            }
        });
    </script>
@endsection