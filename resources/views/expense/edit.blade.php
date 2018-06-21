@extends('layouts.app')
@section('content')
<div class="table_dashboard">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3>Edit Expense</h3></div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <form method="POST" class="form-horizontal" action="/expense/{{ $expense->id }}/edit">
                            {!! csrf_field() !!}
                        <table>
                            <tr>
                                <th>{!! Form::label('supplier', 'Supplier') !!}</th>
                                <th>{!! Form::label('invoice', 'Invoice') !!}</th>
                                <th>{!! Form::label('date', 'Date') !!}</th>
                            </tr>
                            <!--//This should be in a loop that automatically fill our certain data-->
                            <tr>
                                <td>{!! Form::text('supplier', $expense->supplier)!!}
                                    {!! $errors->has('supplier')?$errors->first('supplier'):'' !!}</td>
                                <td>{!! Form::text('invoice', $expense->invoice)!!}
                                    {!! $errors->has('invoice')?$errors->first('invoice'):'' !!}</td>
                                <td>{!! Form::date('date', $expense->date) !!} </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><button class="btn btn-info" style="width:172px;"><input type="image" src="/images/save-files.png" alt="Save" data-toggle="tooltip" data-placement="right" title="Save" /></button></td>
                                <td><button class="btn btn-danger" style="width:140px; height:52px;"><a href="/expense" ><img src="/images/cancel-button.png"></a></button>
                                    </td>
                            </tr>
                        </table>
                    </form>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop