@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Employees</h1>
@stop

@section('content')
    <a class="btn btn-primary" href="{{route('employee.create')}}">Create</a>
    <hr/>
    @include('admin.employee.table')
    {{ $employees->links() }}
@stop
