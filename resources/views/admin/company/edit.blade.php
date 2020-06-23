@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Edit Company {{$company->name}}</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('company.index')}}">Back</a>
    <hr/>

    <form class="form-horizontal" action="{{route('company.update', $company)}}" enctype="multipart/form-data" method="POST">
        @method('patch')
        @include('admin.company.form')
        @csrf
        <div class="box-footer">
            <button type="submit" class="btn btn-default pull-right">Update</button>
        </div>
    </form>
@stop
