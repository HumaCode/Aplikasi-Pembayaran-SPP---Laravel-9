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
                        <thead class="text-center">
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
                                <td class="text-center">{{ $loop->iteration }}.</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->nohp }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->akses }}</td>
                                <td class="text-center">

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
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse



                        </tbody>
                    </table>

                    <div class="mt-2">
                        {{-- pagination --}}
                        {{ $models->links() }}
                    </div>


                </div>

            </div>
        </div>
    </div>

</div>

@endsection