@extends('layouts.app_sneat_wali')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">DATA SISWA</div>

            <div class="card-body">

                <a href="#" class="btn btn-primary btn-sm mb-2">Tambah Data</a>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <td>No</td>
                                <td>Wali Murid</td>
                                <td>Nama</td>
                                <td>NISN</td>
                                <td>Jurusan</td>
                                <td>Kelas</td>
                                <td>Angkatan</td>
                                <td>Created</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->wali->name == 'Belum dilengkapi')
                                    <small class="text-danger"><b>Belum dilengkapi</b></small>
                                    @else
                                    {{ $item->wali->name }}
                                    @endif
                                </td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->jurusan }}</td>
                                <td>{{ $item->kelas }}</td>
                                <td>{{ $item->angkatan }}</td>
                                <td>{{ $item->user->name }}</td>
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