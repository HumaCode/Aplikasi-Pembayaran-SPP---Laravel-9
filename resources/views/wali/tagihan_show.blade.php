@extends('layouts.app_sneat_wali')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">TAGIHAN SPP {{ strtoupper($siswa->nama) }}</div>

            <div class="card-body">

                <table class="table table-sm table-bordered mb-2">
                    <thead>
                        <tr>
                            <td width="1%">No</td>
                            <td>Nama Tagihan</td>
                            <td class="text-center">Jumlah Tagihan</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($tagihan->tagihanDetail as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_biaya }}</td>
                            <td class="text-end">{{ format_rupiah($item->jumlah_biaya) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-center"><strong>Total Pembayaran</strong></td>
                            <td class="text-end"><strong>{{ format_rupiah($tagihan->tagihanDetail->sum('jumlah_biaya'))
                                    }}</strong></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="alert alert-secondary mt-4" role="alert">
                    Pembayaran bisa dilakukan dengan cara langsung ke Operator sekolah, atau di tranfer melalu bank
                    milik sekolah, sebagai berikut :

                    <p class="text-warning mt-3"><i class="fas fa-circle-exclamation"></i> &nbsp; Jangan Melakukan
                        Tranfer Ke Rekening selain dari
                        Rekening dibawah ini.</p>
                </div>

                <ul>
                    <li>
                        <a href="">Cara Melakukan Pembayaran dengan Tranfer melalui ATM</a>
                    </li>
                    <li>
                        <a href="">Cara Melakukan Pembayaran dengan Tranfer melalui Internet Banking</a>
                    </li>
                </ul>

                <p>Setelah melakukan pembayaran, silahkan upload bukti pembayaran melalui tombol konfirmasi yang ada
                    dibawah ini. </p>

                <div class="row">
                    @foreach ($banksekolah as $itemBank)
                    <div class="col-md-6">
                        <div class="alert alert-danger" role="alert">
                            <table>

                                <tr>
                                    <td width="100">Nama Bank</td>
                                    <td>: &nbsp;</td>
                                    <td>{{ $itemBank->nama_bank }}</td>
                                </tr>
                                <tr>
                                    <td>No. Rekening</td>
                                    <td>: &nbsp;</td>
                                    <td>{{ $itemBank->nomor_rekening }}</td>
                                </tr>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td>: &nbsp;</td>
                                    <td>{{ $itemBank->nama_rekening }}</td>
                                </tr>
                            </table>
                            <div class="text-end">
                                <button class="btn btn-primary btn-sm mt-3 ">Konfirmasi Pembayaran</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

</div>
@endsection