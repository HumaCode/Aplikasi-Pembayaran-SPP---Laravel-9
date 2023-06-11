<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\Biaya;
use App\Models\Siswa;
use App\Models\Tagihan as Model;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    private $viewIndex      = 'tagihan_index';
    private $viewCreate     = 'tagihan_form';
    private $viewEdit       = 'tagihan_form';
    private $viewShow       = 'tagihan_show';
    private $routePrefix    = 'tagihan';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // pencarian
        if ($request->filled('q')) {
            $models = Model::with('user', 'siswa')->search($request->q)->paginate(50);
        } else {
            $models = Model::with('user', 'siswa')->latest()->paginate(50);
        }

        return view('operator.' . $this->viewIndex, [
            'models'        => $models,
            'title'         => 'Data Tagihan',
            'routePrefix'   => $this->routePrefix,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siswa = Siswa::all();

        $data = [
            'model'     => new Model(),
            'method'    => 'POST',
            'route'     => $this->routePrefix . '.store',
            'button'    => 'Simpan Data',
            'title'     => 'Tambah Data Tagihan',
            'angkatan'  => $siswa->pluck('angkatan', 'angkatan'),
            'kelas'     => $siswa->pluck('kelas', 'kelas'),
            // 'biaya'     => Biaya::get()->pluck('nama_biaya_full', 'id'),
            'biaya'     => Biaya::get(),
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanRequest $request)
    {
        // 1. lakukan validasi
        // 2. ambil data biaya yang ditagihkan
        // 3. ambil data siswa yang ditagih berdasarkan kelas / angkatan
        // 4. lakukakan perulangan berdasarkan data siswa
        // 5. didalam perulangan, simpan tagihan berdasarkan biaya dan siswa
        // 6. simpan notifikasi database untuk tagihan
        // 7. kirim pesan WA
        // 8. redirect back()
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Model $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Model $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagihanRequest  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagihanRequest $request, Model $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $tagihan)
    {
        //
    }
}
