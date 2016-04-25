@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Roles</h4>
            <a href="{{route('manager.roles.create')}}" class="btn btn-success pull-right" style="margin-top: -35px;">Create New Role</a>
        </div>
    	<div class="panel-body">
    	   <table class="table table-condensed table-hover">
    	   	<thead>
    	   		<tr>
    	   			<th>Role Name</th>
    	   			<th>Role Label</th>
                    <th></th>
    	   		</tr>
    	   	</thead>
           @if(!count($roles)>0)
               <tfoot>
                    <td colspan="3" class="text-center">There is no any role</td>
               </tfoot>
           @endif
    	   	<tbody>
                @foreach($roles as $role )
                    <tr>
                        <td>{{$role->name}}</td>
                        <td>{{$role->label}}</td>
                        <td>
                            <a href="{{route("manager.roles.edit", $role->id)}}" class="btn-xs btn btn-primary">edit</a>
                        </td>
                    </tr>
                @endforeach
    	   	</tbody>
    	   </table>
    	</div>
    </div>
@endsection