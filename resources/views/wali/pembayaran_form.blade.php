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

                <small><i class="fas fa-circle-exclamation"></i> &nbsp; INFORMASI REKENING PENGIRIM</small>
                <div class="card mb-3" style="background-color: #e9e9e9">
                    <div class="card-header">
                        <div class="alert alert-warning" role="alert">
                            Informasi ini dibutuhkan agar operator sekolah dapat memverifikasi pembayaran yang dilakukan
                            oleh wali murid melalui bank.
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="nama_pengirim" class="mb-1">Nama Bank Pengirim</label>
                                    {!! Form::select('bank_id', $listBank, null, ['class' => 'form-control select2',
                                    'placeholder' =>
                                    '-- Pilih --']) !!}
                                    <span class="text-danger">{{ $errors->first('nama_pengirim') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="rekening_bank_pengirim" class="mb-1">Nama Bank Pengirim</label>
                                    {!! Form::text('rekening_bank_pengirim', null, ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('rekening_bank_pengirim') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="no_rekening_bank_pengirim" class="mb-1">No Rekening Pengirim</label>
                                    {!! Form::text('no_rekening_bank_pengirim', null, ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('no_rekening_bank_pengirim') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <small><i class="fas fa-circle-exclamation"></i> &nbsp; INFORMASI REKENING TUJUAN</small>
                <div class="card mb-3" style="background-color: #e9e9e9">

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="bank_id" class="mb-1">Bank Tujuan</label>
                            {!! Form::select('bank_id', $listBankSekolah, request('bank_sekolah_id'), ['class' =>
                            'form-control
                            select2', 'placeholder' => '-- Pilih --', 'id' => 'pilih_bank']) !!}
                            <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                        </div>

                        @if (request('bank_sekolah_id') != '')
                        <div class="alert alert-dark mt-2 mb-2" role="alert">
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
                    </div>
                </div>


                <small><i class="fas fa-circle-exclamation"></i> &nbsp; INFORMASI PEMBAYARAN</small>
                <div class="card mb-3" style="background-color: #e9e9e9">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal_bayar" class="mb-1">Tanggal Bayar</label>
                                    {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? date('Y-m-d'), ['class' =>
                                    'form-control'])
                                    !!}
                                    <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="jumlah_dibayar" class="mb-1">Jumlah Yang Dibayarkan</label>
                                    {!! Form::text('jumlah_dibayar', null, ['class' =>
                                    'form-control rupiah'])
                                    !!}
                                    <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                                </div>
                            </div>
                        </div>



                        <div class="form-group mb-3">
                            <label for="bukti_bayar" class="mb-1">Bukti Bayar</label>
                            {!! Form::file('bukti_bayar', ['class' =>
                            'form-control'])
                            !!}
                            <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                        </div>

                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>


@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
    crossorigin="anonymous"></script>




<script>
    $(document).ready(function() {
        $('#pilih_bank').change(function() {
            // e.preventDevault();
        
            var bankId = $(this).find(":selected").val();
            window.location.href = "{!! $url !!}&bank_sekolah_id=" + bankId;

            // alert(bankId);

        })
    })
</script>
@endpush