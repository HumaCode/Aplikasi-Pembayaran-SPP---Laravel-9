@extends('layouts.app_sneat_blank')

@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-8">
            <div class="p-3 bg-white rounded">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-uppercase">KWITANSI PEMBAYARAN</h1>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Nama Sekolah :
                            </span><span class="ml-1">SD Negeri Sejahtera</span></div>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Tanggal Tagihan : </span><span
                                class="ml-1">{{ $pembayaran->tanggal_bayar->translatedFormat('d F Y') }}</span></div>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Pembayaran ID : </span><span
                                class="ml-1">#{{ $pembayaran->id }}</span></div>
                    </div>

                </div>
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Metode Bayar</th>
                                    <th>Jumlah Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $pembayaran->tanggal_bayar->translatedFormat('d/m/Y') }}</td>
                                    <td>{{ $pembayaran->metode_pembayaran }}</td>
                                    <td>{{ format_rupiah($pembayaran->jumlah_dibayar) }}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-right mb-3 text-end fst-italic">
                    Terbilang : {{ ucwords(terbilang($pembayaran->jumlah_dibayar)) }} Rupiah
                </div>

                <hr>
                <div>
                    Pekalongan, {{ $pembayaran->tanggal_bayar->translatedFormat('d F Y') }}
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="text-decoration-underline">Operator : {{ $pembayaran->user->name }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.print();
</script>

@endsection