@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">DATA TAGIHAN SPP SISWA, {{ strtoupper($periode) }}</div>

            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td rowspan="8" width="200">
                            <img src="{{ \Storage::url($siswa->foto ?? 'images/noimg.png') }}" width="200"
                                alt="{{ $siswa->nama }}">
                        </td>
                    </tr>
                    <tr>
                        <td width="100">NISN</td>
                        <td>:</td>
                        <td>{{ $siswa->nisn }}</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $siswa->nama }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="row mt-2">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">DATA TAGIHAN {{ strtoupper($periode) }}</div>
            <div class="card-body">

                <table class="table table-sm table-bordered my-2">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Tagihan</td>
                            <td>Jumlah Tagihan</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tagihan->tagihanDetail as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_biaya }}</td>
                            <td>{{ format_rupiah($item->jumlah_biaya) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr class="mx-3 mb-0">

            <div class="card-header mt-0">DATA PEMBAYARAN</div>

            <div class="card-body">

                {!! Form::model($model, [
                'route' => 'pembayaran.store',
                'method' => 'POST',
                ]) !!}

                <div class="form-group mb-3">
                    <label for="tanggal_pembayaran" class="mb-1">Tanggal Pembayaran</label>
                    {!! Form::date('tanggal_pembayaran', $model->tanggal_bayar ?? \Carbon\Carbon::now(), ['class' =>
                    'form-control']) !!}
                    <span class="text-danger">{{ $errors->first('tanggal_pembayaran') }}</span>
                </div>

                <div class="form-group mb-3">
                    <label for="jumlah_bayar" class="mb-1">Jumlah Bayar</label>
                    {!! Form::text('jumlah_bayar', null, ['class' =>
                    'form-control rupiah']) !!}
                    <span class="text-danger">{{ $errors->first('jumlah_bayar') }}</span>
                </div>

                <div class="form-group mb-2">
                    {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">KARTU SPP</div>
            <div class="card-body">
                Kartu SPP
            </div>
        </div>
    </div>
</div>
@endsection