<div class="box-body">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="Name" value="{{$company->name ?? ''}}">
            @if($errors->has('name'))
                {{$errors->first('name')}}
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" name="email" placeholder="Email" value="{{$company->email ?? ''}}">
            @if($errors->has('email'))
                {{$errors->first('email')}}
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Website</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="website" placeholder="Website"
                   value="{{$company->website ?? ''}}">
            @if($errors->has('website'))
                {{$errors->first('website')}}
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Logo</label>
        <div class="col-sm-10">
            @if(isset($company))
                <img width="100px" src="{{$company->logoUrl}}" alt="{{$company->name}} logo"/>
            @endif
            <input type="file" class="form-control" name="logo" placeholder="Logo" value="{{$company->logo ?? ''}}">
            @if($errors->has('logo'))
                {{$errors->first('logo')}}
            @endif
        </div>
    </div>

</div>
