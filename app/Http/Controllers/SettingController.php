<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Settings;

class SettingController extends Controller
{
    public function create()
    {
        $data = [
            'title' => 'Konfigurasi Aplikasi'
        ];

        return view('operator.setting_form', $data);
    }

    public function store(Request $request)
    {
        $dataSetting = $request->except('_token');

        settings()->set($dataSetting);

        flash('Data berhasil diubah');
        return back();
    }
}
