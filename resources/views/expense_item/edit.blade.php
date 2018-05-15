@extends('layouts.app')

@section('header')
    <h2>Edit Expense</h2>
@stop

@section('content')
    
    <div class="table_dashboard">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Enter A New Expense</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        {!! Form::model($expense_item, ['route'=>['expenseitem.update', $expense_item->id], 'method'=>'PATCH']) !!}
                            <table>
                                <tr> 
                                    <th>{!! Form::label('expense_id', 'expense_id') !!}</th>
                                    <th>{!! Form::label('description', 'Description') !!}</th>
                                    <th>{!! Form::label('category', 'Category') !!}</th>
                                    <th>{!! Form::label('amount', 'Amount') !!}</th>
                                    <th>{!! Form::label('gst', 'GST') !!}</th>
                                    <th>{!! Form::label('pst', 'PST') !!}</th>
                                </tr>
                                <!--//This should be in a loop that automatically fill our certain data-->
                                <tr>
                                    <td>{!! Form::text('expense_id', null)!!}</td>
                                    <td>{!! Form::text('description', null)!!}
                                        {!! $errors->has('description')?$errors->first('description'):'' !!}</td>
                                    <td>{!! Form::text('category', null)!!}
                                        {!! $errors->has('category')?$errors->first('category'):'' !!}</td>
                                    <td>{!! Form::text('amount', null)!!}</td>
                                    <td>{!! Form::text('gst', null)!!}</td>
                                    <td>{!! Form::text('pst', null)!!}</td>

                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{!! Form::close() !!}
@stop