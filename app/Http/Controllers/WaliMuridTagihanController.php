<?php

namespace App\Http\Controllers;

use App\Models\BankSekolah;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        $data = [
            'tagihan' => Tagihan::waliSiswa()->get(),
        ];

        return view('wali.tagihan_index', $data);
    }

    public function show($id)
    {
        $tagihan = Tagihan::waliSiswa()->findOrFail($id);
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();


        $data = [
            'tagihan'       => $tagihan,
            'siswa'         => $tagihan->siswa,
            'banksekolah'   => BankSekolah::all(),
        ];

        return view('wali.tagihan_show', $data);
    }
}
