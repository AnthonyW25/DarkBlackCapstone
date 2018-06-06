<table>
    <tr>
        <th>{!! Form::label('description', 'Description') !!}</th>
        <th>{!! Form::label('category', 'Category') !!}</th>
        <th>{!! Form::label('amount', 'Amount') !!}</th>
        <th>{!! Form::label('gst', 'GST') !!}</th>
        <th>{!! Form::label('pst', 'PST') !!}</th>
    </tr>

    <tr>
        <td>{!! Form::text('description', null)!!}
            {!! $errors->has('description')?$errors->first('description'):'' !!}</td>
        <td>{!! Form::select('category', ['Food' => 'Food', 'Beverage' => 'Beverage', 'Alcohol'=>'Alcohol']);!!}
            {!! $errors->has('category')?$errors->first('category'):'' !!}</td>
        <td>{!! Form::text('amount', null)!!}</td>
        <td>{!! Form::text('gst', null)!!}</td>
        <td>{!! Form::text('pst', null)!!}</td>
    </tr>
</table>

