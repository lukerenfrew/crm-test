<div class="box-body">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">First name</label>
        <div class="col-sm-10">
            <input type="name" class="form-control  {{ $errors->has('firstname') ? 'is-invalid' : '' }}"
                   name="firstname" placeholder="Firstname"
                   value="{{$employee->firstname ?? ''}}">
            @if($errors->has('firstname'))
                <div class="invalid-feedback">
                    <strong>
                        {{$errors->first('firstname')}}
                    </strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="surname" class="col-sm-2 control-label">Last name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control  {{ $errors->has('surname') ? 'is-invalid' : '' }}" name="surname"
                   placeholder="Last name"
                   value="{{$employee->surname ?? ''}}">
            @if($errors->has('surname'))
                <div class="invalid-feedback">
                    <strong>
                        {{$errors->first('surname')}}
                    </strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                   placeholder="Email"
                   value="{{$employee->email ?? ''}}">
            @if($errors->has('email'))
                <div class="invalid-feedback">
                    <strong>
                        {{$errors->first('email')}}
                    </strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="phone" class="col-sm-2 control-label">Phone number</label>
        <div class="col-sm-10">
            <input type="text" class="form-control  {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone"
                   placeholder="Phone number"
                   value="{{$employee->phone ?? ''}}">
            @if($errors->has('phone'))
                <div class="invalid-feedback">
                    <strong>
                        {{$errors->first('phone')}}
                    </strong>
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="company" class="col-sm-2 control-label">Company</label>
        <div class="col-sm-10">

            <select class="form-control  {{ $errors->has('company') ? 'is-invalid' : '' }}" name="company">
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
                <div class="invalid-feedback">
                    <strong>
                        {{$errors->first('company')}}
                    </strong>
                </div>
            @endif
        </div>
    </div>
</div>
