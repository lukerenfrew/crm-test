@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Create employee</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('employee.index')}}">Back</a>
    <hr/>

    <form class="form-horizontal" action="{{route('employee.store')}}" method="POST" enctype="multipart/form-data">
        @include('admin.employee.form')
        @csrf
        <div class="box-footer">
            <button type="submit" class="btn btn-default pull-right">Create</button>
        </div>
    </form>
@stop
