@extends('layouts.app_sneat')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true]) !!}

                <div class="form-group mb-3">
                    {!! Form::label('wali_id', 'Nama', ['class' => 'mb-1']) !!}

                    {!! Form::select('wali_id', $wali, null, ['class' => 'form-control select2']) !!}
                    <span class="text-danger">{{ $errors->first('wali_id') }}</span>
                </div>

                <div class="form-group mb-3">
                    {{-- <label for="name">Nama</label> --}}
                    {!! Form::label('nama', 'Nama', ['class' => 'mb-1']) !!}
                    {!! Form::text('nama', null , ['class' => 'form-control', 'autofocus', 'id' => 'nama']) !!}
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('nisn', 'NISN', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::text('nisn', null , ['class' => 'form-control', 'id' => 'nisn']) !!}
                    <span class="text-danger">{{ $errors->first('nisn') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('jurusan', 'Jurusan', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::select('jurusan', [
                    '' => '--Pilih--',
                    'RPL' => 'Rekayasa Perangkat Lunak',
                    'TKJ'=> 'Teknik Komputer dan Jaringan',
                    ], null, ['class' => 'form-control']) !!}
                    <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('kelas', 'Kelas', ['class' => 'mb-1']) !!}

                    {!! Form::selectRange('kelas', 1, 6, null, ['class' => 'form-control']) !!}
                    <span class="text-danger">{{ $errors->first('kelas') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('angkatan', 'Angkatan', ['class' => 'mb-1']) !!}

                    {!! Form::selectRange('angkatan', 2022, date('Y')+1, null, ['class' => 'form-control']) !!}
                    <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('foto', 'Foto (Format: jpeg, jpg, png, Ukuran max: 5MB)', ['class' => 'mb-1']) !!}

                    {!! Form::file('foto', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                    <span class="text-danger">{{ $errors->first('foto') }}</span>
                </div>

                {!! Form::submit($button, ['class' => 'btn btn-primary btn-sm mt-3']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>

@endsection