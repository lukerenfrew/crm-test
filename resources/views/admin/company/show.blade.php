@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Company: {{$company->name}}</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('company.index')}}">Back</a>
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
                <td>{{$company->website}}</td>
            </tr>
            <tr>
                <th>Logo:</th>
                <td><img width="100px" src="{{$company->logo}}" alt="{{$company->name}} logo"/></td>
            </tr>
            <tr>
            </tr>
            </tbody>
        </table>

    </div>

@stop
