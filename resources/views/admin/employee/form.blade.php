<div class="box-body">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">First name</label>
        <div class="col-sm-10">
            <input type="name" class="form-control" name="firstname" placeholder="Firstname"
                   value="{{$employee->firstname ?? ''}}">
            @if($errors->has('firstname'))
                {{$errors->first('firstname')}}
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="surname" class="col-sm-2 control-label">Last name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="surname" placeholder="Last name"
                   value="{{$employee->surname ?? ''}}">
            @if($errors->has('surname'))
                {{$errors->first('surname')}}
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" name="email" placeholder="Email"
                   value="{{$employee->email ?? ''}}">
            @if($errors->has('email'))
                {{$errors->first('email')}}
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Phone number</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="phone" placeholder="Phone number"
                   value="{{$employee->phone ?? ''}}">
            @if($errors->has('phone'))
                {{$errors->first('phone')}}
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Company</label>
        <div class="col-sm-10">

            <select class="form-control" name="company">
                <option>Select company</option>
                @foreach($companies as $company)
                    <option
                        @if(isset($employee) && $company->id === $employee->company->id) selected @endif
                    value="{{$company->id}}"
                    >
                        {{$company->name}}
                    </option>
                @endforeach
            </select>
            @if($errors->has('company'))
                {{$errors->first('company')}}
            @endif
        </div>
    </div>

</div>
