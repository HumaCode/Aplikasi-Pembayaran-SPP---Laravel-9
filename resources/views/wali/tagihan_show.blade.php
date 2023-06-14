@extends('layouts.app_sneat_wali')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">TAGIHAN SPP {{ strtoupper($siswa->nama) }}</div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-2 text-center mb-2">
                        <img src="{{ \Storage::url($siswa->foto ?? 'images/noimg.png') }}" width="200"
                            alt="{{ $siswa->nama }}" class="img-fluid">
                    </div>

                    <div class="col-md-5">
                        <table class="table table-sm ">

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
                            <tr>
                                <td>Jurusan</td>
                                <td>:</td>
                                <td>{{ $siswa->jurusan }}</td>
                            </tr>
                            <tr>
                                <td>Angkatan</td>
                                <td>:</td>
                                <td>{{ $siswa->nama }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>:</td>
                                <td>{{ $siswa->kelas }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-5 ">
                        <table class="table table-sm">
                            <tr>
                                <td>No. Tagihan</td>
                                <td>:</td>
                                <td>#{{ $tagihan->id }}</td>
                            </tr>
                            <tr>
                                <td>Tgl. Tagihan</td>
                                <td>:</td>
                                <td>{{ $tagihan->tanggal_tagihan->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Tgl. Akhir Pembayaran</td>
                                <td>:</td>
                                <td>{{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td>:</td>
                                <td>{{ $tagihan->getStatusTagihanWali() }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><a href="" target="_blank"><i class="fas fa-file "></i>
                                        &nbsp; Cetak
                                        Invoice Tagihan</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>


                <br>

                <table class="table table-sm table-bordered mb-2">
                    <thead class="table-dark">
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

                    <div>Silahkan lihat tatacara melakukan pembayaran melalui <a href=""
                            class="text-primary"><strong>ATM</strong></a> atau <a href="#"
                            class="text-primary"><strong>Internet Bangking</strong></a></div>
                    <p>Setelah melakukan pembayaran, silahkan upload bukti pembayaran melalui tombol konfirmasi yang ada
                        dibawah ini. </p>
                </div>

                <ul>
                    <li>
                        <a href="" class="text-dark">Cara Melakukan Pembayaran dengan Tranfer melalui ATM</a>
                    </li>
                    <li>
                        <a href="" class="text-dark">Cara Melakukan Pembayaran dengan Tranfer melalui Internet
                            Banking</a>
                    </li>
                </ul>



                <div class="row">
                    @foreach ($banksekolah as $itemBank)
                    <div class="col-md-6">
                        <div class="alert alert-dark" role="alert">
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
                                <a href="{{ route('wali.pembayaran.create', [
                                    'tagihan_id' => $tagihan->id,
                                    'bank_sekolah_id' => $itemBank->id,
                                ]) }}" class="btn btn-primary btn-sm mt-3 ">Konfirmasi Pembayaran</a>
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