@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                <div class="table-responsive">
                    {{-- <img src="{{ \Storage::url($model->photo ?? 'images/noimage.jpg') }}" width="150" alt=""> --}}
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <td width="20%">ID</td>
                                <td>: {{ $model->id }}</td>
                            </tr>
                            <tr>
                                <td>NAMA</td>
                                <td>: {{ $model->name }}</td>
                            </tr>
                            <tr>
                                <td>EMAIL</td>
                                <td>: {{ $model->email }}</td>
                            </tr>
                            <tr>
                                <td>NO. HP</td>
                                <td>: {{ $model->nohp }}</td>
                            </tr>
                            <tr>
                                <td>TANGGAL BUAT</td>
                                <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>TANGGAL UBAH</td>
                                <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>

                        </thead>
                    </table>


                    <h4 class="my-3">TAMBAH DATA ANAK</h4>

                    {!! Form::open(['route' => 'walisiswa.store', 'method' => 'POST']) !!}

                    {!! Form::hidden('wali_id', $model->id, []) !!}

                    <div class="form-group">
                        <label for="siswa_id">Pilih Data Siswa</label>
                        {!! Form::select('siswa_id', $siswa, null, ['class' => 'form-control select2']) !!}
                        <span class="text-danger">{{ $errors->first('siswa_id') }}</span>
                    </div>

                    {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary btn-sm my-2']) !!}

                    {!! Form::close() !!}

                    <h4 class="my-3">DATA ANAK</h4>

                    <table class="table table-light">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($model->siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">
                                    {!! Form::open([
                                    'route' => ['walisiswa.update', $item->id],
                                    'method' => 'PUT',
                                    'onsubmit' => 'return confirm("Apakah yakin akan menghapus data ini.?")'
                                    ]) !!}

                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fa-solid fa-trash"></i> &nbsp; Hapus</button>


                                    {!! Form::close() !!}
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
@endsection