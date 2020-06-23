@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Employees</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('employee.create')}}">Create</a>
    <hr/>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Company</th>
            <th width="15%"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($employees as $employee)
            <tr>
                <td><a href="{{route('employee.show', $employee)}}">{{$employee->fullName}}</a></td>
                <td>{{$employee->email}}</td>
                <td><a href="tel:{{$employee->phone}}">{{$employee->phone}}</a></td>
                <td>
                    <a href="{{route('company.show', $employee->company)}}">{{$employee->company->name}}</a>
                </td>
                <td>
                    <a class="btn btn-secondary" href="{{route('employee.edit', $employee)}}">Edit</a>
                    <a class="btn btn-secondary" href="{{route('employee.destroy', $employee)}}">Delete</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{ $employees->links() }}
@stop
