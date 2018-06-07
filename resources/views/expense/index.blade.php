@extends('layouts.app')
<?php
 use Carbon\Carbon;
    use App\Http\Controllers\ExpenseController;
    use App\Forecast;
    use App\COGS;
    use App\Site;  
    use App\Budget;
    $site = new Site();
    $today = Carbon::now();
    $seven_days_ago = $today->copy()->subDay(7);
    $twenty_eight_days_ago = $today->copy()->subDay(28);
    

    $cogs = new COGS($site);
    $forecast = new Forecast($site);
    $budget = new Budget($forecast);
    $cogs->calculate();
?>
@section('content')


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body modal-xl">
        @include('expense.create')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>





    <h1>Expense List</h1>

    <table class="table table-bordered table-responsive" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>Expense ID</th>
                <th>Invoice</th>
                <th>Supplier</th>
                <th>Expense Items</th>
                <th>Item Category</th>
                <th>Total</th>
                <th>GST</th>
                <th>PST</th>
                <th>Date</th>
                <th colspan="3"><!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Add new Expense</button></th>
            </tr>
        </thead>
        <tbody>
        @foreach($expenses as $expense)
            <tr>
                <th>{{ $expense->id }}</th>
                <th>{{ $expense->invoice }}</th>
                <th>{{ $expense->supplier }}</th>
                <td><br>
                @foreach($expense->items as $item)
                    {{ $item->description }}<br>
                @endforeach
                </td>

                <td><br>
                @foreach($expense->items as $item)
                    {{ $item->category }}<br>
                @endforeach
                </td>
                <td><b>$ {{ $expense->total() }}</b><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->amount }}<br>
                @endforeach
                </td>

                <td><b>$ {{ $expense->gst() }}</b><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->gst }}<br>
                @endforeach
                </td>

                <td><b>$ {{ $expense->pst() }}</b><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->pst }}<br>
                @endforeach
                </td>

                <td>
                   <b>{{ $expense->date }}</b>
                </td>

                <td>
                    <a href="{{ route('expense.edit', $expense->id) }}" class="btn btn-success">Edit</a>
                </td>

                <td>
                    {!! Form::open(['method'=>'delete', 'route'=>['expense.destroy', $expense->id]]) !!}
                    {!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>'return confirm("Do you want to delete this record?")']) !!}
                    {!! Form::close() !!}
                </td>

                <td>
                    <form method="get" action="/expenseitem">
                        <input type="hidden" name="expense_id" value="{{ $expense->id }}">
                        <input type="submit" class="btn btn-success" value="Manage Items">
                    </form>
                </td>
            </tr>
      @endforeach
        </tbody>
    </table>

    {{--SPLIT LARGE VIEWS INTO SUB VIEWS AND THEN INCLUDE THEM--}}
    @include('expense._cogs')
    @include('expense._forecast')
@endsection