<div class="box-body">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">

            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"
                   placeholder="Name"
                   value="{{old('name') ?? $company->name ?? ''}}">
            @if($errors->has('name'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                   placeholder="Email"
                   value="{{old('email') ?? $company->email ?? ''}}">
            @if($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="website" class="col-sm-2 control-label">Website</label>
        <div class="col-sm-10">
            <input type="text" class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}" name="website"
                   placeholder="Website"
                   value="{{old('website') ?? $company->website ?? ''}}">
            @if($errors->has('website'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('website') }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="logo" class="col-sm-2 control-label">Logo</label>
        <div class="col-sm-10">
            @if(isset($company))
                <img width="100px" src="{{$company->logoUrl}}" alt="{{$company->name}} logo"/>
            @endif
            <input type="file" class="form-control {{ $errors->has('logo') ? 'is-invalid' : '' }}" name="logo"
                   placeholder="Logo" value="{{$company->logo ?? ''}}">
            @if($errors->has('logo'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('logo') }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>
