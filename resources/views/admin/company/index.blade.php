@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Companies</h1>
@stop

@section('content')

    <a class="btn btn-primary" href="{{route('company.create')}}">Create</a>
    <hr/>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Website</th>
            <th>Logo</th>
            <th width="15%"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($companies as $company)
            <tr>
                <td><a href="{{route('company.show', $company)}}">{{$company->name}}</a></td>
                <td>{{$company->email}}</td>
                <td>{{$company->website}}</td>
                <td>{{$company->logo}}</td>
                <td>
                    <a class="btn btn-secondary" href="{{route('company.edit', $company)}}">Edit</a>
                    <a class="btn btn-secondary" href="{{route('company.destroy', $company)}}">Delete</a>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{ $companies->links() }}
@stop
