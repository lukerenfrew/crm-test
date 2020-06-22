<div class="box-body">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{$company->name ?? ''}}">
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{$company->email ?? ''}}">
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Website</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="website" placeholder="Website" value="{{$company->website ?? ''}}">
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Logo</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="logo" placeholder="Logo" value="{{$company->logo ?? ''}}">
        </div>
    </div>

</div>
