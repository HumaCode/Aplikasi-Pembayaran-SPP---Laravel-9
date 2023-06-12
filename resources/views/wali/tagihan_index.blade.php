@extends('layouts.app_sneat_wali')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">DATA TAGIHAN SPP</div>

            <div class="card-body">

                <a href="#" class="btn btn-primary btn-sm mb-2">Tambah Data</a>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>Jurusan</td>
                                <td>Kelas</td>
                                <td>Tanggal Tagihan</td>
                                <td>Status Pembayaran</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($tagihan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->siswa->jurusan }}</td>
                                <td>{{ $item->siswa->kelas }}</td>
                                <td>{{ $item->tanggal_tagihan }}</td>
                                <td><strong>{{ $item->getStatusTagihanWali() }}</strong></td>
                                <td width="250" class="text-center">

                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse



                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

</div>
@endsection