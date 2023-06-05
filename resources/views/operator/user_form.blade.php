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
                    {!! Form::label('name', 'Nama', ['class' => 'mb-1']) !!}
                    {!! Form::text('name', null , ['class' => 'form-control', 'autofocus', 'id' => 'name']) !!}
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('email', 'Email', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::text('email', null , ['class' => 'form-control', 'id' => 'email']) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('nohp', 'No. Hp', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::number('nohp', null , ['class' => 'form-control', 'id' => 'nohp']) !!}
                    <span class="text-danger">{{ $errors->first('nohp') }}</span>
                </div>

                @if (\Route::is('user.create'))
                <div class="form-group mb-3">
                    {!! Form::label('akses', 'Hak Akses', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::select('akses', [
                    '' => '--Pilih--',
                    'operator' => 'Operator Sekolah',
                    'administrator'=> 'Administrator',
                    ], null, ['class' => 'form-control']) !!}
                    <span class="text-danger">{{ $errors->first('akses') }}</span>
                </div>
                @endif

                <div class="form-group mb-3">
                    {!! Form::label('password', 'Password', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'id' => 'password'])
                    !!}
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>

                {!! Form::submit($button, ['class' => 'btn btn-primary btn-sm mt-3']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>

@endsection