@extends('layouts.app')

@section('header')
    <h2>Expense List</h2>
@stop

@section('content')
    <table class="table table-bordered table-responsive" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>invoice</th>
                <th>date</th>
                <th>supplier</th>
                <th>description</th>
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
                <th>{{ $expense->invoice }}</th>
                <th>{{ $expense->created_at }}</th>
                <th>{{ $expense->supplier }}</th>
                <td><br>  
                <?php 
                        $total = 0; 
                        $totalgst = 0;
                        $totalpst = 0;
                        $expense_items = DB::table('expense_items')->get();
                        foreach ($expense_items as $expense_item){
                            $description = $expense_item->description;
                            $category = $expense_item->category;
                            $amount = $expense_item->amount;
                            $total += $amount;
                            $gst = $expense_item->gst;
                            $totalgst += $gst;
                            $pst = $expense_item->pst;
                            $totalpst += $pst;
                            ?>                             
                            {{csrf_field()}}
                <?php echo $description;?><br>     
                <?php } ?> 
                </td>
                <td><br>
                <?php 
                     foreach ($expense_items as $expense_item){    
                            $category = $expense_item->category;
                            ?>                             
                            {{csrf_field()}}
                <?php echo $category;?><br>   
                <?php } ?> 
                </td>
                <td>
                    <b><?php echo $total;?></b>
                    <br>
                    <?php 
                     foreach ($expense_items as $expense_item){    
                            $amount = $expense_item->amount;
                            ?>                             
                            {{csrf_field()}}
                <?php echo $amount;?><br> 
                <?php } ?></td>
                <td>
                    <b><?php echo $totalgst;?></b><br>
                <?php 
                     foreach ($expense_items as $expense_item){    
                            $gst = $expense_item->gst;
                            ?>                             
                            {{csrf_field()}}
                <?php echo $gst;?><br> 
                <?php } ?>
                </td>
                <td><b><?php echo $totalpst;?></b><br>
                    <?php 
                     foreach ($expense_items as $expense_item){    
                            $pst = $expense_item->pst;
                            ?>                             
                            {{csrf_field()}}
                <?php echo $pst;?><br> 
                <?php } ?>
                
                </td>
                <td>{{ $expense->created_at }}</td>
                <td>{{ $expense->updated_at }}</td>
                <td>
                    <a href="{{ route('expense.edit', $expense->id) }}" class="btn btn-success">Edit</a></td>
                   <td> {!! Form::open(['method'=>'delete', 'route'=>['expense.destroy', $expense->id]]) !!}
                    {!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>'return confirm("Do you want to delete this record?")']) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    <a href="{{ url('/expenseitem') }}" class="btn btn-success">Edit Items</a></td>
            </tr>
      @endforeach
        </tbody>
@stop