@extends('layouts.app')
<?php
 use Carbon\Carbon;
    use App\Http\Controllers\ExpenseController;
    use App\Forecast;
    use App\COGS;
    use App\Site;  

    $site = new Site();
    $today = Carbon::now();
    $seven_days_ago = $today->copy()->subDay(7);
    $twenty_eight_days_ago = $today->copy()->subDay(28);
    

    $cogs = new COGS($site);
    $forecast = new Forecast($site);
    $cogs->calculate();
?>
@section('content')
<!-------Tabs----->
    <div class="row">
        <div class="col-sm-6">
    <h1><b>Expense List</b></h1>
    <table class="table table-hover table-striped table-responsive" style="margin-top: 10px;">
        <thead>
            <tr>
                
                <th>Invoice</th>
                <th>Date</th>
                <th>Supplier</th>
                <th>Expense Items</th>
                <th>Item Category</th>
                <th>Total</th>
                <th>GST</th>
                <th>PST</th>
                
                <th colspan="3"><!-- Button trigger modal -->
                        <button type="button" style="background-color: darkgray;" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="right" title="Add an Expense"><img src="images/add.png"></button></th>
            </tr>
        </thead>
        <tbody>
        @foreach($expenses as $expense)
            <tr>
                
                <th>{{ $expense->invoice }}</th>
                <th>
                   <b>{{ $expense->date }}</b>
                </th>
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
                <td><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->amount }}<br>
                @endforeach
                    <b>$ {{ $expense->total() }}</b><br>
                </td>

                <td><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->gst }}<br>
                @endforeach
                    <b>$ {{ $expense->gst() }}</b><br>
                </td>

                <td><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->pst }}<br>
                @endforeach
                    <b>$ {{ $expense->pst() }}</b><br>
                </td>

                

                <td>
                    <a href="{{ route('expense.edit', $expense->id) }}" data-toggle="tooltip" data-placement="right" title="Edit an Expense"><img src="images/edit-button.png"></a>
                </td>

                <td>
                    {!! Form::open(['method'=>'delete', 'route'=>['expense.destroy', $expense->id]]) !!}
                    <input type="image" src="images/remove-file.png" alt="Manage Items" onclick="return confirm('Do you want to delete this record?')" data-toggle="tooltip" data-placement="right" title="Delete an Expense"/>
                    {!! Form::close() !!}
                </td>

                <td>
                    <form method="get" action="/expenseitem">
                        <input type="hidden" name="expense_id" value="{{ $expense->id }}">
                        <input type="image" src="images/chest.png" alt="Manage Items" data-toggle="tooltip" data-placement="right" title="Manage Expense"/> 
                    </form>
                </td>
            </tr>
      @endforeach
        </tbody>
    </table>
        </div>
        <div class="col-sm-6">
            @include('expense._forecast')
            @include('expense._cogs')
        </div>
</div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" data-placement="right" title="Cancel"><img src="images/close.png"></button>
      </div>
      <div class="modal-body modal-xl">
        @include('expense.create')
      </div>
    </div>
  </div>
</div>
<!---<div>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>  --->  


    {{--SPLIT LARGE VIEWS INTO SUB VIEWS AND THEN INCLUDE THEM--}}


@endsection