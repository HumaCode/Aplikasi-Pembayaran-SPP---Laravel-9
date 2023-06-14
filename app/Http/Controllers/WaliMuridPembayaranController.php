<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankSekolah;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;

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
        ];

        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        }

        $data['url'] = route('wali.pembayaran.create', [
            'tagihan_id'        => $request->tagihan_id,
        ]);


        return view('wali.pembayaran_form', $data);
    }
}
