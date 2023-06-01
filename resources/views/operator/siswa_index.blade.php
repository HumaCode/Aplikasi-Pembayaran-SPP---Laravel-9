@extends('layouts.app_sneat')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data</a>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Wali Murid</td>
                                <td>Nama</td>
                                <td>NISN</td>
                                <td>Jurusan</td>
                                <td>Kelas</td>
                                <td>Angkatan</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->wali->name == 'Belum dilengkapi')
                                    <span class="text-danger"><b>Belum dilengkapi</b></span>
                                    @else
                                    {{ $item->wali->name }}
                                    @endif
                                </td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->jurusan }}</td>
                                <td>{{ $item->kelas }}</td>
                                <td>{{ $item->angkatan }}</td>
                                <td>

                                    {!! Form::open([
                                    'route' => [$routePrefix.'.destroy', $item->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => 'return confirm("Apakah yakin akan menghapus data ini.?")'
                                    ]) !!}

                                    <a href="{{ route($routePrefix.'.edit', $item->id) }}"
                                        class="btn btn-success btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                        &nbsp; Edit</a>

                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fa-solid fa-trash"></i> &nbsp; Hapus</button>


                                    {!! Form::close() !!}
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">Tidak ada data</td>
                            </tr>
                            @endforelse



                        </tbody>
                    </table>

                    {{-- pagination --}}
                    {!! $models->links() !!}

                </div>

            </div>
        </div>
    </div>

</div>

@endsection