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

                dd($waliBank);
            }
        } else {
            $waliBankId     = $request->wali_bank_id;
            $waliBank       = WaliBank::findOrFail($waliBankId);
        }

        dd($waliBank);
    }
}
