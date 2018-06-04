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
                {{--The expense should know it's own totals. The view should never call methods on a Controller, remember, views are dumb--}}
                {{--<td><b>{{ "$" .ExpenseController::amountTotal($expense->id)}}</b><br>--}}
                <td><b>$ {{ $expense->total() }}</b><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->amount }}<br>
                @endforeach
                </td>

{{--                <td><b>{{ "$" .ExpenseController::amountGst($expense->id)}}</b><br>--}}
                <td><b>$ {{ $expense->gst() }}</b><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->gst }}<br>
                @endforeach
                </td>

{{--                <td><b>{{ "$" .ExpenseController::amountPst($expense->id)}}</b><br>--}}
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
    {{--@include('expense._cogs')--}}

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
                    {{"$"}}{{isset($totals['Food']) ? $totals['Food']:0}}
                </b></td>
                <td><b>{{"$" . ($site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100)}}</b></td>
                <td>{!! Form::number('number', 33) !!} % </td>
                <td>
                    <?php 
                        if(($cogs->twenty_eight_day_food * 100) < 1 and ($cogs->twenty_eight_day_food > 0 * 100)) {
                            echo ' < 1%';
                        }
                        else {
                            echo (int)($cogs->twenty_eight_day_food * 100) . "%";
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
                    {{"$"}}{{isset($totals['Alcohol']) ? $totals['Alcohol']:0}}
                </b></td>
                <td><b>{{"$" . ($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100)}}</b></td>
                <td>33%</td>
                <td>
                    <?php
                        if($cogs->twenty_eight_day_alcohol < 1 and $cogs->twenty_eight_day_alcohol > 0) {
                            echo ' < 1%';
                        }
                        else {
                            echo (int)($cogs->twenty_eight_day_alcohol * 100) . "%";
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
                {{"$"}}{{isset($totals['Beverage']) ? $totals['Beverage']:0}} 
                </b></td>
                <td><b>{{"$" . ($site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) / 100)}}</b></td>
                <td>33%</td>
                <td>
              <?php
                    if(($cogs->twenty_eight_day_beverage * 100) < 1 and ($cogs->twenty_eight_day_beverage * 100) > 0) {
                            echo ' < 1%';
                        }
                        else {
                            echo (int)($cogs->twenty_eight_day_beverage * 100) . "%";
                        }
                    ?>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Total</th>
                <td><b>{{"$"}}</b></td>
                <td><b>{{"$" . (($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) + $site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) +  $site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString())) / 100)}}</b></td>
            </tr>
            
        </tbody>
    </table>
@endsection