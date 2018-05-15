@extends('layouts.app')

@section('header')
    <h2>Expense List</h2>
@stop

@section('content')
    <a href="expense/create" class="btn btn-primary">Add new</a>
    <table class="table table-bordered table-responsive" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>user ID</th>
                <th>site_ID</th>
                <th>supplier</th>
                <th>invoice</th>
                <th>total</th>
                <th>created at</th>
                <th>updated at</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->id }}</td>
                <td>{{ $expense->user_id }}</td>
                <td>{{ $expense->site_id }}</td>
                <td>{{ $expense->supplier }}</td>
                <td>{{ $expense->invoice }}</td>
                <td>{{ $expense->total }}</td>
                <td>{{ $expense->created_at }}</td>
                <td>{{ $expense->updated_at }}</td>
                <td>
                    <a href="{{ route('expense.edit', $expense->id) }}" class="btn btn-success">Edit</a></td>
                   <td> {!! Form::open(['method'=>'delete', 'route'=>['expense.destroy', $expense->id]]) !!}
                    {!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>'return confirm("Do you want to delete this record?")']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
      @endforeach
        </tbody>
@stop