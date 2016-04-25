@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Languages</h4>
            <a href="{{route('manager.languages.create')}}" class="btn btn-success pull-right" style="margin-top: -35px;">Create A New Language</a>
        </div>
    	<div class="panel-body">
    	   <table class="table table-condensed table-hover">
    	   	<thead>
    	   		<tr>
    	   			<th>Language</th>
                    <th></th>
    	   		</tr>
    	   	</thead>
           @if(!count($languages)>0)
               <tfoot>
                    <td colspan="3" class="text-center">There is no language set</td>
               </tfoot>
           @endif
    	   	<tbody>
                @foreach($languages as $language )
                    <tr>
                        <td>{{$language->label}}</td>
                        <td>
                            <button class="btn-xs btn btn-primary" data-id="{{$language->id}}">edit</button>
                        </td>
                    </tr>
                @endforeach
    	   	</tbody>
    	   </table>
    	</div>
    </div>
@endsection