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
                            <img src="{{ \Storage::url($siswa->foto) }}" width="200" alt="{{ $siswa->nama }}">
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
            <div class="card-header">DATA TAGIHAN</div>
            <div class="card-body">
                Data Tagihan
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