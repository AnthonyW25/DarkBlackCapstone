@extends('layouts.app')

@section('content')

    <h2>Expense List</h2>

    <table class="table table-bordered table-responsive" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>id</th>
                <th>invoice</th>
                <th>date</th>
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
                <th>{{ $expense->created_at }}</th>
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
                <td><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->amount }}<br>
                @endforeach
                </td>
                <td><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->gst }}<br>
                @endforeach
                </td>
                <td><br>
                @foreach($expense->items as $item)
                    {{ "$" . $item->pst }}<br>
                @endforeach
                </td>
                <!--
                        * Don't do anything like this in a View
                         * Views should be "dumb" they just display information given to them
                         * Calculations and "work" should be done in the Controller or Model
                     $_SESSION['expense_id'] = $expense->id;
                        $total = 0;
                        $totalgst = 0;
                      $totalpst = 0;
                        $expense_items = DB::table('expense_items')
                       ->where('expense_id', '=', $_SESSION['expense_id'])->orderBy('updated_at','DESC')->get();
                       foreach ($expense_items as $expense_item){
                            $description = $expense_item->description;
                        $category = $expense_item->category;
                          $amount = $expense_item->amount;
                            $total += $amount;
                           $gst = $expense_item->gst;
                            $totalgst += $gst;
                            $pst = $expense_item->pst;
                           $totalpst += $pst;
                  -->         
        
                <td>{{ $expense->created_at }}</td>
                <td>{{ $expense->updated_at }}</td>
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
@endsection