@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Create Company</h1>
@stop

@section('content')
    <a class="btn btn-primary" href="{{url()->previous()}}">Back</a>
    <hr/>
    <form class="form-horizontal" action="{{route('company.store')}}" method="POST" enctype="multipart/form-data">
        @include('admin.company.form')
        @csrf
        <div class="box-footer">
            <button type="submit" class="btn btn-default pull-right">Create</button>
        </div>
    </form>
@stop
