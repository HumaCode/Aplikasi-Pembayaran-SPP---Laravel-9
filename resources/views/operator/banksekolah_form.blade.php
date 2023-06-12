@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}




                <div class="form-group mb-3">
                    {!! Form::label('bank_id', 'Nama Bank', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::select('bank_id', $listbank, null, ['class' => 'form-control select2']) !!}
                    <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('nama_rekening', 'Pemilik Rekening', ['class' => 'mb-1']) !!}
                    {!! Form::text('nama_rekening', null, ['class' => 'form-control', 'id' =>
                    'nama_rekening']) !!}
                    <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('nomor_rekening', 'Nomor Rekening', ['class' => 'mb-1']) !!}
                    {!! Form::number('nomor_rekening', null, ['class' => 'form-control', 'id' =>
                    'nomor_rekening', 'min' => 0]) !!}
                    <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                </div>

                {!! Form::submit($button, ['class' => 'btn btn-primary btn-sm mt-3']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
@endsection