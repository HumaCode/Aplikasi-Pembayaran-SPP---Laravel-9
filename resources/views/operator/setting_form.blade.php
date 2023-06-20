@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                {!! Form::open([
                'route' => 'setting.store',
                'method' => 'POST',
                ]) !!}


                <div class="divider">
                    <div class="divider-text">
                        <i class="bx bx-star"></i> &nbsp;
                        PENGATURAN INSTANSI &nbsp;
                        <i class="bx bx-star"></i>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            {{-- <label for="name">Nama</label> --}}
                            {!! Form::label('app_name', 'Nama Instansi', ['class' => 'mb-1']) !!}
                            {!! Form::text('app_name', settings()->get('app_name'), ['class' => 'form-control',
                            'autofocus', 'id' =>
                            'app_name']) !!}
                            <span class="text-danger">{{ $errors->first('app_name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            {!! Form::label('app_email', 'Email Instansi', ['class' => 'mb-1 mt-2']) !!}
                            {!! Form::text('app_email', setting()->get('app_email'), ['class' => 'form-control', 'id' =>
                            'app_email'])
                            !!}
                            <span class="text-danger">{{ $errors->first('app_email') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            {!! Form::label('app_phone', 'No. Telepon Instansi', ['class' => 'mb-1 mt-2']) !!}
                            {!! Form::text('app_phone', setting()->get('app_phone'), ['class' => 'form-control', 'id' =>
                            'app_phone'])
                            !!}
                            <span class="text-danger">{{ $errors->first('app_phone') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('app_address', 'Alamat Instansi', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::textarea('app_address', setting()->get('app_address'), ['class' => 'form-control',
                    'rows' => 3, 'id' => 'app_address']) !!}
                    <span class="text-danger">{{ $errors->first('app_address') }}</span>
                </div>

                <div class="divider">
                    <div class="divider-text">
                        <i class="bx bx-star"></i> &nbsp;
                        PENGATURAN APLIKASI &nbsp;
                        <i class="bx bx-star"></i>
                    </div>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('app_pagination', 'Data Per Halaman', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::text('app_pagination', setting()->get('app_pagination'), ['class' => 'form-control', 'id'
                    => 'app_pagination'])
                    !!}
                    <span class="text-danger">{{ $errors->first('app_pagination') }}</span>
                </div>





                {!! Form::submit('UPDATE', ['class' => 'btn btn-primary btn-sm mt-3']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
@endsection