<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Http\Requests\StorePembayaranRequest;
use App\Http\Requests\UpdatePembayaranRequest;
use App\Models\Tagihan;
use App\Notifications\PembayaranKonfirmasiNotification;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Pembayaran::latest()->orderBy('tanggal_konfirmasi', 'desc')->paginate(settings()->get('app_pagination', 50));
        $data = [
            'models' => $models,
            'title' => 'Data Pembayaran'
        ];

        return view('operator.pembayaran_index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembayaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
        // $requestData['status_konfirmasi']   = 'sudah';
        $requestData['tanggal_konfirmasi']  = now();
        $requestData['metode_pembayaran']   = 'manual';
        $tagihan                            = Tagihan::findOrFail($requestData['tagihan_id']);
        $requestData['wali_id']             = $tagihan->siswa->wali_id ?? 0;
        if ($requestData['jumlah_dibayar'] >= $tagihan->tagihanDetail->sum('jumlah_biaya')) {
            $tagihan->status = 'lunas';
        } else {
            $tagihan->status = 'angsur';
        }
        $tagihan->save();
        Pembayaran::create($requestData);

        flash('Pembayaran berhasil disimpan')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();

        return view('operator.pembayaran_show', [
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembayaranRequest  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $wali = $pembayaran->wali;
        $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));

        $pembayaran->tanggal_konfirmasi = now();
        $pembayaran->user_id            = auth()->user()->id;
        $pembayaran->save();

        $pembayaran->tagihan->status = 'lunas';
        $pembayaran->tagihan->save();

        flash('Pembayaran berhasil dikonfirmasi')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
