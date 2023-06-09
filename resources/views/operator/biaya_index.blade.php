@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data</a>

                {!! Form::open(['route' => $routePrefix.'.index', 'method' => 'GET']) !!}

                <div class="input-group mb-2">
                    <input type="text" class="form-control" name="q" placeholder="Cari Nama Siswa"
                        value="{{ request('q') }}" />
                    <button class="btn btn-outline-primary" type="submit"><i class="bx bx-search"></i></button>
                </div>

                {!! Form::close() !!}

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <td>No</td>
                                <td>Biaya</td>
                                <td>Jumlah</td>
                                <td>Created</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td width="250" class="text-center">

                                    {!! Form::open([
                                    'route' => [$routePrefix . '.destroy', $item->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => 'return confirm("Apakah yakin akan menghapus data ini.?")',
                                    ]) !!}

                                    {{-- <a href="{{ route($routePrefix . '.show', $item->id) }}"
                                        class="btn btn-info btn-sm mb-1"><i class="fa-regular fa-eye"></i>
                                        &nbsp; Detail</a> --}}

                                    <a href="{{ route($routePrefix . '.edit', $item->id) }}"
                                        class="btn btn-success btn-sm mb-1"><i class="fa-regular fa-pen-to-square"></i>
                                        &nbsp; Edit</a>

                                    <button type="submit" class="btn btn-danger btn-sm mb-1"><i
                                            class="fa-solid fa-trash"></i> &nbsp; Hapus</button>


                                    {!! Form::close() !!}
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
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