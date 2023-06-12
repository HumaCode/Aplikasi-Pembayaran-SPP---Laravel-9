@extends('layouts.app_sneat_blank')

@section('content')

<div class="container mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-8">
            <div class="p-3 bg-white rounded">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-uppercase">KARTU SPP</h1>
                        {{-- <div class="billed"><span class="font-weight-bold text-uppercase">Nama Sekolah :
                            </span><span class="ml-1">SD Negeri Sejahtera</span></div>
                        <div class="billed"><span class="font-weight-bold text-uppercase">Nama Siswa :
                            </span><span class="ml-1">{{ $siswa->nama }}</span></div> --}}

                        <table>
                            <tr>
                                <td width="150">NAMA SEKOLAH</td>
                                <td>:</td>
                                <td>SD Negeri Sejahtera</td>
                            </tr>
                            <tr>
                                <td>NAMA SISWA</td>
                                <td>:</td>
                                <td>{{ $siswa->nama }}</td>
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan Tagihan</th>
                                    <th>Item Tagihan</th>
                                    <th>Jumlah</th>
                                    <th>Paraf</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($tagihan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal_tagihan->translatedFormat('F Y') }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($item->tagihanDetail as $itemDetail)
                                            <li>{{ $itemDetail->nama_biaya }} - {{
                                                format_rupiah($itemDetail->jumlah_biaya) }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ format_rupiah($item->tagihanDetail->sum('jumlah_biaya')) }}</td>
                                    <td>
                                        ...........
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- <script>
    window.print();
</script> --}}

@endsection