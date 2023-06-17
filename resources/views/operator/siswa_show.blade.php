@extends('layouts.app_sneat')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">{{ $title }}</div>

            <div class="card-body">

                <div class="table-responsive">
                    <img src="{{ ($model->foto == null) ? asset('assets/img/avatars/noimg.png') : \Storage::url($model->foto) }}"
                        width="150" alt="">

                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <td width="20%">Status Siswa</td>
                                <td>:
                                    @if ($model->status == 'aktif')
                                    <span class="badge text-bg-success">{{ $model->status }}</span>

                                    @else
                                    <span class="badge text-bg-danger">{{ $model->status }}</span>

                                    @endif
                                </td>
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

                    <h3 class="mt-3">Daftar Tagihan</h3>

                    <table class="table table-sm table-bordered mb-2">
                        <thead class="fw-bold text-center">
                            <tr>
                                <td width="10%">No</td>
                                <td>Nama Tagihan</td>
                                <td width="150">Jumlah Tagihan</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($model->biaya->childern as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}.</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-end">{{ format_rupiah($item->jumlah) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><strong>Total Pembayaran</strong></td>
                                <td class="text-end"><strong>{{
                                        format_rupiah($model->biaya->childern->sum('jumlah'))
                                        }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>

            </div>

            <div class="card-footer">
                @if ($model->status == 'aktif')

                <a href="{{ route('status.update', [
                    'model' => 'siswa',
                    'id' => $model->id,
                    'status' => 'non-aktif',
                ]) }}" class="badge text-bg-danger" onclick="return confirm('Non-Aktifkan Akun Ini..?')">Nonaktifkan
                    Akun</a>

                @else
                <a href="{{ route('status.update', [
                    'model' => 'siswa',
                    'id' => $model->id,
                    'status' => 'aktif',
                ]) }}" class="badge text-bg-success" onclick="return confirm('Aktifkan Akun Ini..?')">Aktifkan Akun</a>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection