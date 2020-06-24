@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Employee: {{$employee->fullName}}</h1>
@stop

@section('content')
    <a class="btn btn-primary" href="{{url()->previous()}}">Back</a>
    <a class="btn btn-primary" href="{{route('employee.edit', $employee)}}">Edit</a>
    <hr/>
    <div>
        <table class="table table-bordered">
            <thead>
            <tbody>
            <tr>
                <th>Name:</th>
                <td>{{$employee->fullName}}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{$employee->email}}</td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td>
                    @if($employee->phone)
                        <a href="tel:{{$employee->phone}}">{{$employee->phone}}</a>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
                <th>Company:</th>
                <td><a href="{{route('company.show', $employee->company)}}">{{$employee->company->name}}</a></td>
            </tr>
            </tbody>
        </table>
    </div>
@stop
