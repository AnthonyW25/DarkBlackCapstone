@extends('layouts.app')

@section('content')
<?php 
    use App\Http\Controllers\ExpenseController;
    use App\Http\Controllers\SaleController;
    $salesInstace = new SaleController;
 ?>
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

                <th colspan="3"><a href="expense/create" class="btn btn-primary">Add new Expense</a></th>
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
                <th></th>
                <th colspan="3">4 Weeks</th>
                <th colspan="3">Expenses This Week</th>
            </tr>
            <tr>
                <th></th>
                <th>Expenses</th>
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

                    if (isset($totalCategory['Food'])){
                        echo "$" . $totalCategory['Food'];
                    }
                        else{echo "$0";}
                    ?> 
                </b></td>
                <td>{!! Form::number('number', 33) !!} % </td>
                <td>


                    <?php 
                    
                        $twenty_eight_day_result = ExpenseController::total_twenty_eight_days();//we will store the twenty eight day avg ifo into this variable
                                                                                                //this is so we can output the info to the page 
                        ExpenseController::total_seven_days();//just rungs the seven day avg function to store it in the database; will not be output to display at the moment
                    ?>
                    {{(int)$twenty_eight_day_result[0] . "%"}}

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
                    }
                    else{echo "$0";}
                    ?>
                </b></td>
                <td>33%</td>
                <td>
                    <?php $result = ExpenseController::total_twenty_eight_days()?>
                    <?php
                    if($result[0] < 1 and $result[0] > 0) {
                        echo ' < 1%';
                    }
                    else {
                        echo (int)$result[1] . "%";
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
                    }
                    else{echo "$0";}
                    ?> 
                </b></td>
                <td>33%</td>
                <td>
                    <?php $result = ExpenseController::total_twenty_eight_days()?>
                    <?php
                    if($result[0] < 1 and $result[0] > 0) {
                        echo ' < 1%';
                    }
                    else {
                        echo (int)$result[2] . "%";
                    }
                    ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            
            
        </tbody>
    </table>
@endsection