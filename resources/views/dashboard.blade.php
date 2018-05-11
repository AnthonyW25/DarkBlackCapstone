
@extends('layouts.app')

<style>
    table, th {
        border-spacing: 15px;
        padding: 15px;
        border: 2px solid black;
    }

    td{
        border-spacing: 15px;
        padding: 15px;
        border: 1px solid black;
    }


</style>

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

                        HELLO Dashboard!</br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table_dashboard">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Expenses</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Total</th>
                                    <th>GST</th>
                                    <th>PST</th>
                                    <td> <a href="{{ url('/create') }}">Add New Item</a></td>

                                </tr>
                                <tr>
                                    <td>1001</td>
                                    <td>1 Jan</td>
                                    <td>Superstore</td>
                                    <td>Food</td>
                                    <td>100</td>
                                    <td>2</td>
                                    <td>1</td>

                                    <td><button type="button">Edit Entry</button></td>
                                </tr>
                            </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


