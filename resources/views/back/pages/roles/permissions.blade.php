@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Permissions for {{$role->label}}</h4>
            <a href="" class="btn btn-success pull-right" style="margin-top: -35px;"></a>
        </div>
    	<div class="panel-body">
    	   <table class="table table-condensed table-hover">
    	   	<thead>
    	   		<tr>
    	   			<th>Permission Label</th>
                    <th></th>
    	   		</tr>
    	   	</thead>
           @if(!count($role->permissions)>0)
               <tfoot>
                    <td colspan="3" class="text-center">There is no permission given to {{$role->label}}</td>
               </tfoot>
           @endif
    	   	<tbody>
                @foreach($role->permissions as $permission )
                    <tr>
                        <td>{{$permission->label}}</td>
                        <td>
                            <button class="btn-xs btn btn-primary" data-id="{{$permission->id}}">edit</button>
                        </td>
                    </tr>
                @endforeach
    	   	</tbody>
    	   </table>
            <a href="{{route('manager.roles.edit', $role->id )}}" class="btn btn-primary">Back</a>
            <a href="{{route('manager.roles.permissions.create', $role->id )}}" class="btn btn-info">Edit Permission</a>
        </div>
    </div>

@endsection