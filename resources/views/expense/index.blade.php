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
                    {{ (int)($cogs->twenty_eight_day_food * 100) . "%"}}
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
                   {{(int)($cogs->twenty_eight_day_alcohol * 100) . "%"}} 
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
                    {{(int)($cogs->twenty_eight_day_beverage * 100) . "%"}}
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Total</th>
                <td><b>{{"$" . array_sum($totals)}}</b></td>
                <td><b>{{"$" . (($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) + $site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) +  $site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString())) / 100)}}</b></td>
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
            <td rowspan="3">{{"$" . number_format((float)($cogs->twenty_eight_day_avg /100), 2, '.', '')}}</td>

            <?php
                if (isset($_GET['subject']))
                {
                    $fore_percent = $_GET['subject'];
                    $forecast->growth($fore_percent);
                    $forecast->date();
                    $forecast->forecastCalculation();
                    
                }
                else
                {
                    $forecast->forecastCalculation();
                    $forecast->getPercentage();
                    $fore_percent = $forecast->growth_rate;
                }
            ?>
            <td><form name="form" action="" method="get">
                <input type="number" name="subject" id="subject" value="{{$fore_percent}}">
                <input type="submit" name="my_form_submit_button" 
                    value="SCALE"/>
                </form>
            </td>
            <td><?php
                    if(isset($_GET['subject'])){
                        $fore_percent = $_GET['subject'];
                        $forecast->growth($fore_percent);
                        $forecast->date();
                        $forecast->forecastCalculation();
                        echo "$" . number_format((float)($forecast->seven_day  /100), 2, '.', '');
                    }
                    else{
                        $forecast->getPercentage();
                        $forecast->forecastCalculation();
                        $fore_percent = $forecast->growth_rate;
                        echo "$" . number_format((float)($forecast->seven_day  /100), 2, '.', '');
                    }?>
                    </td>
        </tr>
        </tbody>
    </table>
@endsection