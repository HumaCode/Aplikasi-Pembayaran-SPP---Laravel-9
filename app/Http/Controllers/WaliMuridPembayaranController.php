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
        $data = [
            'tagihan'       => Tagihan::where('id', $request->tagihan_id)->first(),
            'bankSekolah'   => BankSekolah::findOrFail($request->bank_sekolah_id),
            'model'         => new Pembayaran(),
            'method'        => 'POST',
            'route'         => 'wali.pembayaran.store',
            'listBank'      => Bank::pluck('nama_bank', 'id'),
        ];

        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        }

        return view('wali.pembayaran_form', $data);
    }
}
