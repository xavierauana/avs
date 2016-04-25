@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Hotels</h4>
            <a href="{{route("manager.hotels.create")}}" class="btn btn-success pull-right" style="margin-top: -35px;">Create New Hotel</a>
        </div>
    	<div class="panel-body">
    	   <table class="table table-condensed table-hover">
    	   	<thead>
    	   		<tr>
    	   			<th>Hotel Name</th>
    	   			<th>Property Owner</th>
                    <th></th>
    	   		</tr>
    	   	</thead>
           @if(!count($hotels)>0)
               <tfoot>
                    <td colspan="3" class="text-center">No Hotels</td>
               </tfoot>
           @endif
    	   	<tbody>
                @foreach($hotels as $hotel)
                    <tr>
                        <td>{{$hotel->name}}</td>
                        <td>{{$hotel->owner}}</td>
                        <td>
                            <button class="btn-xs btn btn-primary" data-id="{{$hotel->id}}">edit</button>
                        </td>
                    </tr>
                @endforeach
    	   	</tbody>
    	   </table>
    	</div>
    </div>
@endsection