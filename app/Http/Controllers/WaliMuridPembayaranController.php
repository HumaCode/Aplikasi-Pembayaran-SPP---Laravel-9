<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankSekolah;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\WaliBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridPembayaranController extends Controller
{
    public function create(Request $request)
    {
        // return $request->bank_sekolah_id;

        $data = [
            'tagihan'           => Tagihan::waliSIswa()->findOrFail($request->tagihan_id),
            'model'             => new Pembayaran(),
            'method'            => 'POST',
            'route'             => 'wali.pembayaran.store',
            'listBankSekolah'   => BankSekolah::pluck('nama_bank', 'id'),
            'listBank'          => Bank::pluck('nama_bank', 'id'),
            'listWaliBank'      => WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id'),
        ];

        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        }

        $data['url'] = route('wali.pembayaran.create', [
            'tagihan_id'        => $request->tagihan_id,
        ]);


        return view('wali.pembayaran_form', $data);
    }

    public function store(Request $request)
    {
        if ($request->wali_bank_id == '' && $request->nomor_rekening == '') {
            flash('Silahkan pilih bank pengirim')->error();
            return back();
        }


        if ($request->filled('pilihan_bank')) {
            $bankId                 = $request->bank_id;
            $bank                   = Bank::findOrFail($bankId);


            if ($request->filled('simpan_data_rekening')) {
                $requestDataBank = $request->validate([
                    'nama_rekening'    => 'required',
                    'nomor_rekening'   => 'required',
                ]);

                $waliBank = WaliBank::firstOrCreate(
                    $requestDataBank,
                    [
                        'nama_rekening' => $requestDataBank['nama_rekening'],
                        'wali_id'       => Auth::user()->id,
                        'kode'          => $bank->sandi_bank,
                        'nama_bank'     => $bank->nama_bank,
                    ]
                );
            }
        } else {
            $waliBankId     = $request->wali_bank_id;
            $waliBank       = WaliBank::findOrFail($waliBankId);
        }

        $request->validate([
            'tanggal_bayar'     => 'required',
            'jumlah_dibayar'    => 'required',
            'bukti_bayar'       => 'required|image|mimes:jpg,png,jpeg|max:5048',
        ]);


        $buktiBayar = $request->file('bukti_bayar')->store('public');

        $dataPembayaran = [
            'bank_sekolah_id'   => $request->bank_sekolah_id,
            'wali_bank_id'      => $waliBank->id,
            'tagihan_id'        => $request->tagihan_id,
            'wali_id'           => auth()->user()->id,
            'tanggal_bayar'     => $request->tanggal_bayar,
            'status_konfirmasi' => 'belum',
            'jumlah_dibayar'    => str_replace('.', '', $request->jumlah_dibayar),
            'bukti_bayar'       => $buktiBayar,
            'metode_pembayaran' => 'transfer',
            'user_id'           => 0,
        ];

        Pembayaran::create($dataPembayaran);
        flash('Pembayaran berhasil disimpan dan akan segera dikonfirmasi oleh operator')->success();
        return back();
    }
}
