@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary btn-sm mb-2">Tambah
                            Data</a>
                    </div>
                    <div class="col-md-6">
                        {!! Form::open(['route' => $routePrefix.'.index', 'method' => 'GET']) !!}

                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control mb-1']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::selectRange('tahun', 2023, date('Y') +1, request('tahun'), ['class' =>
                                'form-control mb-1']) !!}
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>



                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-center">
                            <tr>
                                <td>No</td>
                                <td>NISN</td>
                                <td>Nama</td>
                                <td>Tanggal Tagihan</td>
                                <td>Status</td>
                                <td>Aksi</td>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($models as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->siswa->nisn }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->tanggal_tagihan->format('d-M-Y') }}</td>
                                <td>{{ $item->status }}</td>
                                <td width="250" class="text-center">

                                    {!! Form::open([
                                    'route' => [$routePrefix . '.destroy', $item->id],
                                    'method' => 'DELETE',
                                    'onsubmit' => 'return confirm("Apakah yakin akan menghapus data ini.?")',
                                    ]) !!}

                                    <a href="{{ route($routePrefix . '.show', [
                                        $item->siswa_id,
                                        'siswa_id'  => $item->siswa_id,
                                        'bulan'     => $item->tanggal_tagihan->format('m'),
                                        'tahun'     => $item->tanggal_tagihan->format('Y'),
                                    ]) }}" class="btn btn-info btn-sm mx-3 mb-1"><i class="fa-regular fa-eye"></i>
                                        &nbsp; Detail</a>


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