@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                {!! Form::model($model, ['route' => $route, 'method' => $method]) !!}

                @if (request()->filled('parent_id'))
                <h3>{{ $parentData->nama }}</h3>

                {!! Form::hidden('parent_id', $parentData->id, []) !!}

                <table class="table table-hover table-sm my-2">
                    <thead class="table-dark text-center ">
                        <tr>
                            <th class="text-white" width="15%">Parent ID</th>
                            <th class="text-white">Nama Biaya</th>
                            <th class="text-white">Jumlah</th>
                            <th class="text-white">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($parentData->childern as $item)

                        <tr>
                            <td class="text-center">{{ $loop->iteration }}.</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ format_rupiah($item->jumlah) }}</td>
                            <td class="text-center">

                                <a href="{{ route('delete.biaya.item', $item->id) }}" class="btn btn-danger btn-sm"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Hapus"
                                    onclick="return confirm('Anda yakin akan menghapus data ini..?')"><i
                                        class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
                @endif

                <div class="form-group mb-3">
                    {{-- <label for="name">Nama</label> --}}
                    {!! Form::label('nama', 'Nama Biaya', ['class' => 'mb-1']) !!}
                    {!! Form::text('nama', null, ['class' => 'form-control', 'autofocus', 'id' => 'nama']) !!}
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('jumlah', 'Jumlah / Nominal', ['class' => 'mb-1 mt-2']) !!}
                    {!! Form::text('jumlah', null, ['class' => 'form-control rupiah', 'id' => 'jumlah'])
                    !!}
                    <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                </div>

                {!! Form::submit($button, ['class' => 'btn btn-primary btn-sm mt-3']) !!}

                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
@endsection