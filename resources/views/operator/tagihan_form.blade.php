@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            {!! Form::label('tanggal_tagihan', 'Tanggal Tagihan', ['class' => 'mb-1 mt-2']) !!}
                            {!! Form::date('tanggal_tagihan', $model->tanggal_tagihan ?? date('Y-m-').'01', ['class' =>
                            'form-control', 'id' =>
                            'tanggal_tagihan'])
                            !!}
                            <span class="text-danger">{{ $errors->first('tanggal_tagihan') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            {!! Form::label('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', ['class' => 'mb-1 mt-2']) !!}
                            {!! Form::date('tanggal_jatuh_tempo', $model->tanggal_jatuh_tempo ?? date('Y-m-').'10',
                            ['class'
                            =>
                            'form-control', 'id' =>
                            'tanggal_jatuh_tempo'])
                            !!}
                            <span class="text-danger">{{ $errors->first('tanggal_jatuh_tempo') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('keterangan', 'Keterangan', ['class' => 'mb-1']) !!}
                    {!! Form::textarea('keterangan', null, ['class' => 'form-control', 'rows' => 3]) !!}
                    <span class="text-danger">{{ $errors->first('keterangan') }}</span>
                </div>





                {!! Form::submit($button, ['class' => 'btn btn-primary btn-sm mt-3']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
@endsection