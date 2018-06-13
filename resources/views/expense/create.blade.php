
<h2>Add Expense</h2>
{!! Form::open(['url'=>'expense']) !!}
<table>
    <tr>
        <th>{!! Form::label('supplier', 'Supplier') !!}</th>
        <th>{!! Form::label('invoice', 'Invoice') !!}</th>
        <th>{!! Form::label('date', 'Date') !!}</th>
    </tr>
    <!--//This should be in a loop that automatically fill our certain data-->
    <tr>
        <td>{!! Form::text('supplier')!!}
            {!! $errors->has('supplier')?$errors->first('supplier'):'' !!}</td>
        <td>{!! Form::text('invoice', null)!!}
            {!! $errors->has('invoice')?$errors->first('invoice'):'' !!}</td>
        <td>{!! Form::date('date', now()) !!} </td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td><button class="btn btn-info" style="width:140px;"><input type="image" src="images/save-files.png" alt="Save" data-toggle="tooltip" data-placement="right" title="Save" /></button></td>
    </tr>
</table>

{!! Form::close() !!}
