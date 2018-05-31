
@extends('layouts.app')

@section('content')
<?php 
    session_start();
    use Carbon\Carbon;
    use App\Http\Controllers\ExpenseController;
    use App\Forecast;
    use App\COGS;
    use App\Site;
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

</script>


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
                    $site = new Site();
                    $today = Carbon::now();

                    $seven_days_ago = $today->copy()->subDay(7);

                    $twenty_eight_days_ago = $today->copy()->subDay(28);

                    $total_expenses = 0;
                    //gets the totals of all categories for 28 days, soon the user will be able to decide the days
                    $expenses_for_days = ExpenseController::categoryTotal($twenty_eight_days_ago->toDateString(), $today->toDateString());

               
                    $cogs = new COGS($site);
                    $forecast = new Forecast($site);
                    $cogs->calculate();
                                                
                    if (isset($expenses_for_days['Food'])){
                        $total_expenses += $expenses_for_days['Food'];
                        echo "$" . $expenses_for_days['Food'];
                    }
                        else{echo "$0";}
                    ?> 
                </b></td>
                <td><b>{{"$" . $site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString())}}</b></td>
                <td>{!! Form::number('number', 33) !!} % </td>
                <td>

                    <?php 
                        if($cogs->twenty_eight_day_food < 1 and $cogs->twenty_eight_day_food > 0) {
                            echo ' < 1%';
                        }
                        else {
                            echo (int)$cogs->twenty_eight_day_food . "%";
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
                    if (isset($expenses_for_days['Alcohol'])){
                        $total_expenses += $expenses_for_days['Alcohol'];
                        echo "$" . $expenses_for_days['Alcohol'];
                    }
                    else{echo "$0";}
                    ?>

                </b></td>
                <td><b>{{"$" . $site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString())}}</b></td>
                <td>33%</td>
                <td>

                    <?php
                        if($cogs->twenty_eight_day_alcohol < 1 and $cogs->twenty_eight_day_alcohol > 0) {
                            echo ' < 1%';
                        }
                        else {
                            echo (int)$cogs->twenty_eight_day_alcohol . "%";
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
                    if (isset($expenses_for_days['Beverage'])){
                        $total_expenses += $expenses_for_days['Beverage'];
                        echo "$" . $expenses_for_days['Beverage'];
                    }
                    else{echo "$0";}
                    ?> 

                </b></td>
                <td><b>{{"$" . $site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString())}}</b></td>
                <td>33%</td>
                <td>

              <?php
                    if($cogs->twenty_eight_day_beverage < 1 and $cogs->twenty_eight_day_beverage > 0) {
                            echo ' < 1%';
                        }
                        else {
                            echo (int)$cogs->twenty_eight_day_beverage . "%";
                        }
                    ?>

                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Total</th>
                <td><b>{{"$" . $total_expenses}}</b></td>
                <td><b>{{"$" . ($site->alcoholSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) + $site->foodSales($twenty_eight_days_ago->toDateString(), $today->toDateString()) +  $site->beverageSales($twenty_eight_days_ago->toDateString(), $today->toDateString()))}}</b></td>
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
            <td rowspan="3">{{"$" . $cogs->seven_day_avg}}</td>
            <?php
                if (isset($_GET['subject']))
                {
                    $fore_percent = $_GET['subject'];
                    $_SESSION['subject'] = $fore_percent;
                    $forecast->forecastCalculation($fore_percent);
                }
                else
                {
                    $forecast->getPercentage();
                    $fore_percent = $forecast->growth_rate;
                    $forecast->forecastCalculation($fore_percent);
                }
            ?>
            <td><form name="form" action="" method="get">
                <input type="number" name="subject" id="subject" value={{$fore_percent}}>
                <input type="submit" name="my_form_submit_button" 
                    value="SCALE"/>
                </form>
            </td>
            <td><?php
                    if(isset($_GET['subject'])){
                        $fore_percent = $_GET['subject'];
                        echo "$" . (int)$forecast->seven_day;
                    }
                    else{
                        $fore_percent = $forecast->growth_rate;
                        echo "$" . (int)$forecast->seven_day;
                    }
                    
?></td>
        </tr>

        </tbody>



    </table>
@endsection