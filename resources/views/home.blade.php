
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br>
                    HELLO WORLD!<br>
                        <a href="{{ url('/dashboard') }}">View Dev Dashboard</a>
                <a href="{{ url('/expenseitem') }}">View Expense Item</a>
                    <a href="{{ url('/expense') }}">View Expenses</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection