
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

    <div class="table_dashboard">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Enter A New Expense</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="create.blade.php">
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Total</th>
                                    <th>GST</th>
                                    <th>PST</th>
                                    <td><a href="{{ url('/dashboard') }}">Save (ToDO)</a></br>
                                        <a href="{{ url('/dashboard') }}">Cancel (ToDO)</a>
                                    </td>
                                </tr>
                                <!--//This should be in a loop that automatically fill our certain data-->
                                <tr>
                                    <!--//Should automatically increment the next available expense id-->
                                    <th>PlaceHolder ID</th>

                                    <!--//Automatically Assign current date-->
                                    <th>PlaceHolder Date</th>

                                    <!--//User manually enters description such as supplier-->
                                    <th><input type="text" name="desc"></th>

                                    <!--//Should be a drop down menu with available categories-->
                                    <th>PlaceHolder Category</th>

                                    <!--//Totals, PST, and GST will be auto generated from the entries below.-->
                                    <th>Placeholder 0</th>
                                    <th>Placeholder 0</th>
                                    <th>Placeholder 0</th>
                                </tr>
                                <tr>
                                    <td><input type="text" name="itemID"></td>
                                    <td><input type="text" name="date"></td>
                                    <td><input type="text" name="entry"></td>
                                    <td><input type="text" name="category"></td>
                                    <td><input type="text" name="total"></td>
                                    <td><input type="text" name="gst"></td>
                                    <td><input type="text" name="pst"></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><button type="button">Add Item</button></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


