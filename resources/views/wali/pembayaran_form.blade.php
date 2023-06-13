@extends('layouts.app_sneat_wali')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">KONFIRMASI PEMBAYARAN</div>

            <div class="card-body">

                {!! Form::model($model, [
                'route' => $route,
                'method' => $method,
                ]) !!}

                <div class="form-group mb-3">
                    <label for="bank_id" class="mb-1">Bank Tujuan</label>
                    {!! Form::select('bank_id', $listBank, request('bank_Sekolah_id'), ['class' => 'form-control
                    select2', 'placeholder' => '-- Pilih --']) !!}
                    <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                </div>

                @if (request('bank_sekolah_id') != '')
                <div class="alert alert-primary mt-2 mb-2" role="alert">
                    <table>

                        <tr>
                            <td width="100">Nama Bank</td>
                            <td>: &nbsp;</td>
                            <td>{{ $bankYangDipilih->nama_bank }}</td>
                        </tr>
                        <tr>
                            <td>No. Rekening</td>
                            <td>: &nbsp;</td>
                            <td>{{ $bankYangDipilih->nomor_rekening }}</td>
                        </tr>
                        <tr>
                            <td>Atas Nama</td>
                            <td>: &nbsp;</td>
                            <td>{{ $bankYangDipilih->nama_rekening }}</td>
                        </tr>
                    </table>
                </div>
                @endif

                <div class="form-group mb-3">
                    <label for="tanggal_bayar" class="mb-1">Tanggal Bayar</label>
                    {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? date('Y-m-d'), ['class' => 'form-control'])
                    !!}
                    <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                </div>

                <div class="form-group mb-3">
                    <label for="jumlah_dibayar" class="mb-1">Jumlah Yang Dibayarkan</label>
                    {!! Form::text('jumlah_dibayar', null, ['class' =>
                    'form-control rupiah'])
                    !!}
                    <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                </div>

                <div class="form-group mb-3">
                    <label for="bukti_bayar" class="mb-1">Bukti Bayar</label>
                    {!! Form::file('bukti_bayar', ['class' =>
                    'form-control'])
                    !!}
                    <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
@endsection