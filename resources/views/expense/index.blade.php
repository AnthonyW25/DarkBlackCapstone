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
                <th>id</th>
                <th>invoice</th>
                <th>supplier</th>
                <th>the expense details</th>
                <th>category</th>
                <th>total</th>
                <th>GST</th>
                <th>PST</th>
                <th>created at</th>
                <th>updated at</th>
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

        
                <td>{{ $expense->created_at->format('d/m/Y') }}</td>
                <td>{{ $expense->updated_at->format('d/m/Y') }}</td>
                <td>
 
                    <a href="{{ route('expense.edit', $expense->id) }}" class="btn btn-success">Edit</a></td>
                    
                   <td> {!! Form::open(['method'=>'delete', 'route'=>['expense.destroy', $expense->id]]) !!}
                    {!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>'return confirm("Do you want to delete this record?")']) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                
                    <form method="get" action="/expenseitem">
                    <input type="hidden" name="expense_id" value="{{ $expense->id }}">
                    <input type="submit" class="btn btn-success" value="Manage Items">
                    </form>
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
            @foreach($expenses as $expense)
            @foreach($sales as $sale)
            <tr>
                <th>Food</th>
                <td><b>{{ "$" .ExpenseController::foodTotal($expense->id)}}</b></td>
                <td>$33%</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Alcohol</th>
                <td><b>{{ "$" .ExpenseController::alcoholTotal($expense->id)}}</b></td>
                <td>$33%</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Beverages</th>
                <td><b>{{ "$" .ExpenseController::beverageTotal($expense->id)}}</b></td>
                <td>$33%</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
@endsection