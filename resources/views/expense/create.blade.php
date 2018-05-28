
@section('create')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $("#hide").click(function(){
        $("#tr1").hide();
        $("#show").show();
        
    });
    $("#show").click(function(){
        $("#tr1").show();
        $("#show").hide();
    });


});
</script>
<!------------- end of Scripts------------->
<button id="show" class="btn btn-primary">Add expense</button>
<div id="tr1" style="display:none">
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
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}<button id="hide" class="btn btn-danger">Cancel</button></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

{!! Form::close() !!}
    </div>

@stop