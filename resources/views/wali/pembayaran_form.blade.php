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
                'files' => true,
                ]) !!}

                {!! Form::hidden('tagihan_id', request('tagihan_id'), []) !!}

                @if (count($listWaliBank) >= 1)
                <div class="form-group mb-2" id="pilihan_bank">
                    <label for="wali_bank_id" class="mb-1">Pilih Bank Pengirim</label>
                    {!! Form::select('wali_bank_id', $listWaliBank, null, ['class' => 'form-control select2',
                    'placeholder' =>
                    '-- Pilih No Rekening Pengirim --']) !!}
                    <span class="text-danger">{{ $errors->first('wali_bank_id') }}</span>
                </div>

                <div class="form-check mb-3">
                    {!! Form::checkbox('pilihan_bank', 1, false, ['class' => 'form-check-input', 'id'
                    =>
                    'checkboxtoggle']) !!}
                    <label class="form-check-label" for="checkboxtoggle"> Saya akan menggunakan rekening baru </label>
                </div>

                <div class="divider">
                    <div class="divider-text"><i class="fa fa-ellipsis"></i></div>
                </div>
                @endif

                <div id="form_bank_pengirim">
                    <small><i class="fas fa-circle-exclamation"></i> &nbsp; INFORMASI REKENING PENGIRIM</small>
                    <div class="card mb-3" style="background-color: #e9e9e9">
                        <div class="card-header">
                            <div class="alert alert-warning" role="alert">
                                Informasi ini dibutuhkan agar operator sekolah dapat memverifikasi pembayaran yang
                                dilakukan
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
                                        <label for="nama_rekening" class="mb-1">Nama Bank Pengirim</label>
                                        {!! Form::text('nama_rekening', null, ['class' => 'form-control']) !!}
                                        <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="nomor_rekening" class="mb-1">No Rekening Pengirim</label>
                                        {!! Form::text('nomor_rekening', null, ['class' => 'form-control'])
                                        !!}
                                        <span class="text-danger">{{ $errors->first('nomor_rekening')
                                            }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check">
                                {!! Form::checkbox('simpan_data_rekening', 1, true, ['class' => 'form-check-input', 'id'
                                =>
                                'defaultCheck3']) !!}
                                <label class="form-check-label" for="defaultCheck3"> Simpan data ini untuk memudahkan
                                    pembayaran selanjutnya. </label>
                            </div>
                        </div>
                    </div>
                </div>

                <small><i class="fas fa-circle-exclamation"></i> &nbsp; INFORMASI REKENING TUJUAN</small>
                <div class="card mb-3" style="background-color: #e9e9e9">

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="bank_sekolah_id" class="mb-1">Bank Tujuan</label>
                            {!! Form::select('bank_sekolah_id', $listBankSekolah, request('bank_sekolah_id'), ['class'
                            =>
                            'form-control
                            select2', 'placeholder' => '-- Pilih --', 'id' => 'pilih_bank']) !!}
                            <span class="text-danger">{{ $errors->first('bank_sekolah_id') }}</span>
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
                                    {!! Form::text('jumlah_dibayar', $tagihan->tagihanDetail->sum('jumlah_biaya'),
                                    ['class' =>
                                    'form-control rupiah'])
                                    !!}
                                    <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                                </div>
                            </div>
                        </div>



                        <div class="form-group mb-3">
                            <label for="bukti_bayar" class="mb-1">Bukti Bayar <span class="text-danger">(File harus jpg,
                                    png, jpeg, Ukuran
                                    maksimal 5MB)</span></label>
                            {!! Form::file('bukti_bayar', ['class' =>
                            'form-control'])
                            !!}
                            <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                        </div>

                    </div>
                </div>

                {!! Form::submit('KONFIRMASI', ['class' => 'btn btn-primary']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>


@endsection

@push('js')
{{-- <script src="https://code.jquery.com/jquery-3.7.0.js"
    integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script> --}}

<script>
    $(document).ready(function() {
       
       @if (count($listWaliBank) >= 1)
       $('#form_bank_pengirim').hide();
       @else
       $('#form_bank_pengirim').fadeIn();
       @endif

       $('#pilih_bank').change(function() {
           // e.preventDevault();
       
           var bankId = $(this).find(":selected").val();
           window.location.href = "{!! $url !!}&bank_sekolah_id=" + bankId;

           // alert(bankId);

       })


            $("#checkboxtoggle").click(function () {
                if ($(this).is(":checked")) {
                    
                    $("#pilihan_bank").fadeOut();
                    $("#form_bank_pengirim").fadeIn();
                } else {
                    $("#pilihan_bank").fadeIn();
                    $("#form_bank_pengirim").fadeOut();
                }
            });
   })
</script>
@endpush