@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}

                {{-- <div class="form-group mb-3">
                    {!! Form::label('biaya_id', 'Biaya Tagihan', ['class' => 'mb-1']) !!}
                    {!! Form::select('biaya_id', $biaya, null, ['class' => 'form-control', 'multiple' => true]) !!}
                    <span class="text-danger">{{ $errors->first('biaya_id') }}</span>
                </div> --}}

                <div class="mb-3">
                    {{-- @dd($biaya); --}}

                    @foreach ($biaya as $item)

                    <div class="form-check mb-2">

                        {!! Form::checkbox('biaya_id[]', $item->id, null, [
                        'class' => 'form-check-input',
                        'id' => 'defaultCheck' . $loop->iteration ,
                        ]) !!}

                        <label class="form-check-label" for="defaultCheck{{ $loop->iteration }}"> {{
                            $item->nama_biaya_full }} </label>
                    </div>

                    @endforeach
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            {!! Form::label('angkatan', 'Tagihan Untuk Angkatan', ['class' => 'mb-1']) !!}
                            {!! Form::select('angkatan', $angkatan, null, ['class' => 'form-control', 'placeholder' =>
                            '--Pilih--']) !!}
                            <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            {!! Form::label('kelas', 'Tagihan Untuk Kelas', ['class' => 'mb-1']) !!}
                            {!! Form::select('kelas', $kelas, null, ['class' => 'form-control', 'placeholder' =>
                            '--Pilih--']) !!}
                            <span class="text-danger">{{ $errors->first('kelas') }}</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            {!! Form::label('tanggal_tagihan', 'Tanggal Tagihan', ['class' => 'mb-1 mt-2']) !!}
                            {!! Form::date('tanggal_tagihan', $model->tanggal_tagihan ?? date('Y-m-d'), ['class' =>
                            'form-control', 'id' =>
                            'tanggal_tagihan'])
                            !!}
                            <span class="text-danger">{{ $errors->first('tanggal_tagihan') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            {!! Form::label('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', ['class' => 'mb-1 mt-2']) !!}
                            {!! Form::date('tanggal_jatuh_tempo', $model->tanggal_jatuh_tempo ?? date('Y-m-d'), ['class'
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