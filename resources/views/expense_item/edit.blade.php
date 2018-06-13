@extends('layouts.app')
@section('content')   
<div class="table_dashboard">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit an Expense Item</div>
                <div class="card-body">
                    {!! Form::model($expense_item, ['route'=>['expenseitem.update', $expense_item->id], 'method'=>'POST']) !!}
                        <table>
                            <tr> 
                                <!--<th>{!! Form::label('expense_id', 'expense_id') !!}</th>-->
                                <th>{!! Form::label('description', 'Description') !!}</th>
                                <th>{!! Form::label('category', 'Category') !!}</th>
                                <th>{!! Form::label('amount', 'Amount') !!}</th>
                                <th>{!! Form::label('gst', 'GST') !!}</th>
                                <th>{!! Form::label('pst', 'PST') !!}</th>
                            </tr>

                            <tr>
                                <!--<td>{!! Form::text('expense_id', null)!!}</td>-->
                                <td>{!! Form::text('description', null)!!}
                                    {!! $errors->has('description')?$errors->first('description'):'' !!}</td>
                                <td>{!! Form::select('category', ['Food' => 'Food', 'Beverage' => 'Beverage', 'Alcohol'=>'Alcohol']);!!}
                                    {!! $errors->has('category')?$errors->first('category'):'' !!}</td>
                                <td>{!! Form::text('amount', null)!!}</td>
                                <td>{!! Form::text('gst', null)!!}</td>
                                <td>{!! Form::text('pst', null)!!}</td>

                            </tr>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button class="btn btn-info" style="width:172px;"><input type="image" src="/images/save-files.png" alt="Save" data-toggle="tooltip" data-placement="right" title="Save" /></button></td>
                                <td><button class="btn btn-danger" style="width:172px; height:52px;"><a href="/expenseitem?expense_id={{ $expense_id }}" ><img src="/images/cancel-button.png"></a></button>
                                    </td>
                            </tr>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop