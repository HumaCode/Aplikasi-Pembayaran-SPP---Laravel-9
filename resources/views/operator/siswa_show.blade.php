@extends('layouts.app_sneat')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body">

                    <div class="table-responsive">
                        <img src="{{ \Storage::url($model->foto ?? 'images/noimage.jpg') }}" width="150" alt="">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <td width="20%">ID</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td>NAMA</td>
                                    <td>: {{ $model->nama }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>: {{ $model->nisn }}</td>
                                </tr>
                                <tr>
                                    <td>JURUSAN</td>
                                    <td>: {{ $model->jurusan }}</td>
                                </tr>
                                <tr>
                                    <td>KELAS</td>
                                    <td>: {{ $model->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>ANGKATAN</td>
                                    <td>: {{ $model->angkatan }}</td>
                                </tr>
                                <tr>
                                    <td>TANGGAL BUAT</td>
                                    <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>TANGGAL UBAH</td>
                                    <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>DIBUAT OLEH</td>
                                    <td>: {{ $model->user->name }}</td>
                                </tr>
                            </thead>
                        </table>

                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
