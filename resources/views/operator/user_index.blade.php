@extends('layouts.app_sneat')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">Data User</div>

            <div class="card-body">

                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm mb-2">Tambah Data</a>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Nama</td>
                                <td>No. Hp</td>
                                <td>Email</td>
                                <td>Akses</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->nohp }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->akses }}</td>
                                <td>

                                    {!! Form::open([
                                    'route' => ['user.destroy', $item->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => 'return confirm("Apakah yakin akan menghapus data ini.?")'
                                    ]) !!}

                                    <a href="{{ route('user.edit', $item->id) }}" class="btn btn-success btn-sm"><i
                                            class="fa-regular fa-pen-to-square"></i> &nbsp; Edit</a>

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