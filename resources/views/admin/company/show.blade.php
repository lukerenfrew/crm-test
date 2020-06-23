@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Company: {{$company->name}}</h1>
@stop

@section('content')
    <a class="btn btn-primary" href="{{url()->previous()}}">Back</a>
    <a class="btn btn-primary" href="{{route('company.edit', $company)}}">Edit</a>
    <hr/>
    <div>
        <table class="table table-bordered">
            <thead>
            <tbody>
            <tr>
                <th>Name:</th>
                <td>{{$company->name}}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{$company->email}}</td>
            </tr>
            <tr>
                <th>Website:</th>
                <td>{{$company->website ?? 'N/A'}}</td>
            </tr>
            <tr>
                <th>Company:</th>
                <td>
                    @if($company->logo)
                        <img width="100px" src="{{$company->logoUrl}}" alt="{{$company->name}} logo"/>
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            <tr>
            </tr>
            </tbody>
        </table>
    </div>

    <h3>Employees</h3>

    @if($employees->isEmpty())
        <h6>No Employees</h6>
    @else
        @include('admin.employee.table', ['employees' => $employees])
    @endif
@stop
