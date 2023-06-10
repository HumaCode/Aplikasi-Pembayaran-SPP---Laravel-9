@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}


                <div class="form-group mb-3">
                    {{-- <label for="name">Nama</label> --}}
                    {!! Form::label('nama', 'Nama Biaya', ['class' => 'mb-1']) !!}
                    {!! Form::text('nama', null, ['class' => 'form-control', 'autofocus', 'id' => 'nama']) !!}
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('jumlah', 'Jumlah / Nominal', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::text('jumlah', null, ['class' => 'form-control rupiah', 'id' => 'jumlah'])
                    !!}
                    <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                </div>

                {!! Form::submit($button, ['class' => 'btn btn-primary btn-sm mt-3']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
@endsection