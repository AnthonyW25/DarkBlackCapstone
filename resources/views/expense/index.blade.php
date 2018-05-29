@extends('layouts.app')

@section('content')
<?php 
    use App\Http\Controllers\ExpenseController;
    use App\COGS;
    use App\Http\Controllers\SaleController;
    $salesInstace = new SaleController;
 ?>
<!-- Remember to include jQuery :) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<script>
$(document).ready(function(){
    $('#exampleModalLabel').on('shown.bs.modal', function () {
  $('#exampleModal').trigger('focus')
})


});
</script>

<!-- Button trigger modal -->


<!-- Modal -->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Expense</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @include('expense.create')
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       
      </div>
    </div>
  </div>
</div>

<!---------------------- end Modal --------------------------->
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
                <th colspan="3" >
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Add new Expense
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($expenses as $expense)
            <tr>
                <th>{{ $expense->id }}</th>
                <th>{{ $expense->invoice }}</th>
                <th>{{ $expense->supplier }}</th>

                {{--We have access to the expense items through the relationship we defined in the Expense model--}}
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

                <td><b>{{ "$" .ExpenseController::amountTotal($expense->id)}}</b><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->amount }}<br>
                @endforeach
                </td>

                <td><b>{{ "$" .ExpenseController::amountGst($expense->id)}}</b><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->gst }}<br>
                @endforeach
                </td>

                <td><b>{{ "$" .ExpenseController::amountPst($expense->id)}}</b><br>
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




    <!------------------------------------ COGS Table ------------------------>
    <br>
    <h1>Cost Of Goods Sold (COGS)</h1>

    <table class="table table-bordered table-responsive" style="margin-top: 10px;">
        <thead>
            <tr>
                <th  bgcolor="#b3b3b3" >DARKBlack</th>
                <th colspan="4"><center>COGS for the Last 4 Weeks</center></th>
                <th colspan="3">Expenses This Week</th>


            </tr>
            <tr>
                <th>Category</th>
                <th>Expenses</th>
                <th>Sales</th>
                <th>Target</th>
                <th>Actual</th>
                <th>Budget</th>
                <th>Actual</th>
                <th>Remaining</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                
                <th>Food</th>
                <td><b>

                    <?php 
                    $totalCategory = ExpenseController::categoryTotal();//gets the totals of all categories
                    $totalExpenses = 0;

                    /*we will store the twenty eight day avg 
                    ifo into this variable;this is so we can output the info to the page*/
                    $cogs = new COGS();
                    $twenty_eight_day_result = $cogs->total_twenty_eight_days();                       
                    /*just runs the seven day avg function to store it in the database
                    will not be output to display at the moment*/                                                    
                    $cogs->total_seven_days();


                    if (isset($totalCategory['Food'])){
                        echo "$" . $totalCategory['Food'];
                        $totalExpenses += $totalCategory['Food'];
                    }
                        else{echo "$0";}
                    ?> 
                </b></td>
                <td><b>{{"$" . $twenty_eight_day_result[4]}}</b></td>
                <td>{!! Form::number('number', 33) !!} % </td>
                <td>

                    <?php 
                        if($twenty_eight_day_result[0] < 1 and $twenty_eight_day_result[0] > 0) {
                            echo ' < 1%';
                        }
                        else {
                            echo (int)$twenty_eight_day_result[0] . "%";
                        }
                    ?>

                </td>
                <td></td>
                <td></td>
                <td></td>

                
            </tr>
            <tr>
                <th>Alcohol</th>
                <td><b>

                    <?php 
                    if (isset($totalCategory['Alcohol'])){
                        echo "$" . $totalCategory['Alcohol'];
                        $totalExpenses += $totalCategory['Alcohol'];
                    }
                    else{echo "$0";}
                    ?>

                </b></td>
                <td><b>{{"$" . $twenty_eight_day_result[5]}}</b></td>
                <td>33%</td>
                <td>

                    <?php
                    if($twenty_eight_day_result[1] < 1 and $twenty_eight_day_result[1] > 0) {
                        echo ' < 1%';
                    }
                    else {
                        echo (int)$twenty_eight_day_result[1] . "%";
                    }
                    ?>

                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>

                <th>Beverages</th>
                <td><b>
                  
                  <?php 
                    if (isset($totalCategory['Beverage'])){
                        echo "$" . $totalCategory['Beverage'];
                        $totalExpenses += $totalCategory['Beverage'];
                    }
                    else{echo "$0";}
                    ?> 

                </b></td>
                <td><b>{{"$" . $twenty_eight_day_result[6]}}</b></td>
                <td>33%</td>
                <td>

                    <?php
                    if($twenty_eight_day_result[2] < 1 and $twenty_eight_day_result[2] > 0) {
                        echo ' < 1%';
                    }
                    else {
                        echo (int)$twenty_eight_day_result[2] . "%";
                    }
                    ?>

                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Total</th>
                <td><b>{{"$" . $totalExpenses}}</b></td>
                <td><b>{{"$" . (int)$twenty_eight_day_result[3]}}</b></td>
            </tr>


            
        </tbody>
    </table>

    <!------------------------------------ Forecast Table ------------------------>
    <br>
    <h1>Upcoming Sales Forecast</h1>

    <table class="table table-bordered table-responsive" style="margin-top: 10px;">
        <thead>
            <tr>
                <th colspan="3">Sales Forecast</th>
            </tr>
            <tr>
                <th>Average Daily Sales Over Previous 7 Days</th>
                <th>Sales Forecast Adjustment</th>
                <th>Projected Sales </th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <!-- This displays the 7 day average of the past week -->
            <td rowspan="3">{{"$" . (int)$twenty_eight_day_result[7]}}</td>
            <td>{!! Form::number('number', 0) !!} %</td>
            <td>This should show the expected daily sales forecast for upcoming week</td>
        </tr>

        </tbody>



    </table>
@endsection