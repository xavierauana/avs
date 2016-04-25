<div class="form-group">
    <label for="name" class="col-sm-2 control-label">Name:</label>

    <div class="col-sm-10">
        <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="@if(isset($role)) {{$role->name}} @endif">
    </div>
</div>
<div class="form-group">
    <label for="label" class="col-sm-2 control-label">Label: </label>

    <div class="col-sm-10">
        <input name="label" type="text" class="form-control" id="label" placeholder="Label" value="@if(isset($role)) {{$role->label}} @endif">
    </div>
</div>