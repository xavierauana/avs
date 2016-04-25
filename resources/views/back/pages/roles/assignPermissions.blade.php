@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default" id="vue">
        <div class="panel-heading">
            <h4>Assign Permissions to {{$role->label}}</h4>
        </div>
    	<div class="panel-body">
            <div class="row">
                <div class="col-sm-5">
                    <table class="table table-condensed table-hover" id="activePermissions">
                        <thead>
                        <tr>
                            <th>Current Assigned Permission</th>
                        </tr>
                        </thead>
                        @if(!count($role->permissions)>0)
                            <tfoot>
                                <td class="text-center">There is no permission assign to {{$role->name}}</td>
                            </tfoot>
                        @endif
                        <tbody>
                        <form id="currentPermissions">
                            {{csrf_field()}}
                            @foreach( $role->permissions as $permission )
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="{{$permission->id}}"> {{$permission->name}}
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </form>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-2">
                    <div class="btn-group-vertical">
                        <button class="btn btn-danger" v-on="click:removePermissions">Remove Permissions</button>
                        <button class="btn btn-success" v-on="click:assignPermission">Assign Permissions</button>
                    </div>
                </div>
                <div class="col-sm-5">
                    <table class="table table-condensed table-hover">
                        <thead>
                        <tr>
                            <th>Available Permission</th>
                        </tr>
                        </thead>
                        <tbody>
                        <form id="availablePermissions">
                            {{csrf_field()}}
                            @foreach( $permissions as $permission )
                                @if(!$role->permissions->contains($permission))
                                    <tr>
                                        <td>
                                            <div class="checkbox">
                                                <label>
                                                    <input name="{{$permission->name}}" type="checkbox" value="{{$permission->id}}"> {{$permission->name}}
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>

    	</div>
    </div>
@endsection

@section('scripts')
    <script>
        var permissionVue = new Vue({
            el: "#vue",
            methods:{
                removePermissions: function(){
                    data = $('form#currentPermissions').serialize();
                    console.log(data)
                },
                removeTr: function(data){
                    var self = this;
                    data.split("&").map(function(pairs){
                        if(pairs.split("=")[0] != "_token"){
                            $("input[name='"+pairs.split("=")[0]+"']").parents("tr").remove();
                            self.addNewPermission(pairs);
                        }
                    });
                },
                addNewPermission:function(paris){
                    var table = $("table#activePermissions");
                    if(table.find('tfoot')){
                        table.find('tfoot').remove()
                    }
                    table.find('tbody')
                            .append("tr")
                            .append("td")
                            .append("div.checkbox")
                            .append("label")
                            .append("input[type='checkbox'[name='"+paris.split("=")[0]+"']][value='"+paris.paris.split("=")[1]+"']"+paris.paris.split("=")[1])
                },
                assignPermission: function(){
                    var url = "{{route("manager.roles.permissions.store", $role->id)}}";
                    var data = $('form#availablePermissions').serialize();
                    var self = this;
                    self.removeTr(data);
//                    $.post(url, data, function(data){
//                        if(data.response == 'completed') self.removeTr(data)
//                    })
                }
            },
            ready:function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                    }
                })
            }
        })
    </script>
@endsection

