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

                <a href="#" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-file "></i> &nbsp;Kartu
                    Tagihan {{
                    request('tahun') }}</a>
            </div>
        </div>
    </div>

</div>

<div class="row mt-2">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header py-2">DATA TAGIHAN {{ strtoupper($periode) }}</div>
            <div class="card-body">

                <table class="table table-sm table-bordered mb-2">
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
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total Pembayaran</strong></td>
                            <td><strong>{{ format_rupiah($tagihan->tagihanDetail->sum('jumlah_biaya')) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <h5 class="card-header pb-1 pb-0 pt-3"><strong>DATA PEMBAYARAN</strong></h5>
            <div class="card-body">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>TANGGAL</th>
                            <th>JUMLAH</th>
                            <th>METODE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tagihan->pembayaran as $item)
                        <tr>
                            <td>
                                <a href="{{ route('kwitansipembayaran.show', $item->id) }}" target="_blank"><i
                                        class="fas fa-print"></i></a>
                            </td>
                            <td>{{ $item->tanggal_bayar->translatedFormat('d/m/Y') }}</td>
                            <td>{{ format_rupiah($item->jumlah_dibayar) }}</td>
                            <td>{{ $item->metode_pembayaran }}</td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h5 class="mt-3">Status Pembayaran : <strong>{{ strtoupper($tagihan->status) }}</strong></h5>

            </div>
            <div class="card-header py-1"><strong>FORM PEMBAYARAN</strong></div>

            <div class="card-body">

                {!! Form::model($model, [
                'route' => 'pembayaran.store',
                'method' => 'POST',
                ]) !!}

                {!! Form::hidden('tagihan_id', $tagihan->id, []) !!}

                <div class="form-group mb-3">
                    <label for="tanggal_bayar" class="mb-1">Tanggal Pembayaran</label>
                    {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? \Carbon\Carbon::now(), ['class' =>
                    'form-control']) !!}
                    <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                </div>

                <div class="form-group mb-3">
                    <label for="jumlah_dibayar" class="mb-1">Jumlah Bayar</label>
                    {!! Form::text('jumlah_dibayar', null, ['class' =>
                    'form-control rupiah']) !!}
                    <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                </div>

                <div class="form-group mb-2">
                    {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary']) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection