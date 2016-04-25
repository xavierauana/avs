@extends("back.layouts.default")

@section("content")
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Create a new language</h4>
        </div>
    	<div class="panel-body">
    	   <form action="{{route('manager.languages.store')}}" method="post" role="form">
    	   <input type='hidden' name='_token' value='{{csrf_token()}}'>
    	   	<legend>Basic Info</legend>

               <div class="form-group">
                   <label for="name" class="col-sm-2 control-label">Name: </label>

                   <div class="col-sm-10">
                       <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                   </div>
               </div>
               <div class="form-group">
                   <label for="label" class="col-sm-2 control-label">Label: </label>

                   <div class="col-sm-10">
                       <input type="text" class="form-control" name="label" id="label" placeholder="Label">
                   </div>
               </div>
               <div class="form-group">
                   <label for="active" class="col-sm-2 control-label">Active: </label>

                   <div class="col-sm-10">
                       <select name="active" id="active" class="form-control">
                       	<option value="0"> NO </option>
                       	<option value="1"> Yes </option>
                       </select>
                   </div>
               </div>

               <div class="form-group">
                   <label for="default" class="col-sm-2 control-label">Default Language: </label>

                   <div class="col-sm-10">
                       <select name="default" id="default" class="form-control">
                       	<option value="0"> NO </option>
                       	<option value="1"> Yes </option>
                       </select>
                   </div>
               </div>


               <button type="submit" class="btn btn-success">Create</button>
    	   </form>
    	</div>
    </div>
@endsection