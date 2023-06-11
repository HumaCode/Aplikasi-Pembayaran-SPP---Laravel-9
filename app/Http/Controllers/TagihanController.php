<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagihanRequest;
use App\Http\Requests\UpdateTagihanRequest;
use App\Models\Biaya;
use App\Models\Siswa;
use App\Models\Tagihan as Model;
use Carbon\Carbon;
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
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $models = Model::with('user', 'siswa')->groupBy('siswa_id')->latest()
                ->whereMonth('tanggal_tagihan', $request->bulan)
                ->whereYear('tanggal_tagihan', $request->tahun)
                ->paginate(50);
        } else {

            $models = Model::with('user', 'siswa')->groupBy('siswa_id')->latest()->paginate(50);
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
        $requestData = $request->validated();

        // 2. ambil data biaya yang ditagihkan
        $biayaIdArray = $requestData['biaya_id'];

        // 3. ambil data siswa yang ditagih berdasarkan kelas / angkatan
        $siswa = Siswa::query();
        if ($requestData['kelas'] != '') {
            $siswa->where('kelas', $requestData['kelas']);
        }
        if ($requestData['angkatan'] != '') {
            $siswa->where('angkatan', $requestData['angkatan']);
        }
        $siswa = $siswa->get();

        // 4. lakukakan perulangan berdasarkan data siswa
        foreach ($siswa as $item) {
            $itemSiswa = $item;
            $biaya = Biaya::whereIn('id', $biayaIdArray)->get();

            // 5. didalam perulangan, simpan tagihan berdasarkan biaya dan siswa

            foreach ($biaya as $itemBiaya) {
                $dataTagihan = [
                    'siswa_id'              => $itemSiswa->id,
                    'angkatan'              => $requestData['angkatan'],
                    'kelas'                 => $requestData['kelas'],
                    'tanggal_tagihan'       => $requestData['tanggal_tagihan'],
                    'tanggal_jatuh_tempo'   => $requestData['tanggal_jatuh_tempo'],
                    'nama_biaya'            => $itemBiaya->nama,
                    'jumlah_biaya'          => $itemBiaya->jumlah,
                    'keterangan'            => $requestData['keterangan'],
                    'status'                => 'baru',
                ];
                // ubah format tgl ke bentuk karbon
                $tanggalJatuhTempo  = Carbon::parse($requestData['tanggal_jatuh_tempo']);
                $tanggalTagihan     = Carbon::parse($requestData['tanggal_tagihan']);

                // mengambil bulan tagihan berdasakan tgl tagihan & jatuh tempo
                $bulanTagihan = $tanggalTagihan->format('m');
                $tahunTagihan = $tanggalTagihan->format('Y');


                $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                    ->where('nama_biaya', $itemBiaya->nama)
                    ->whereMonth('tanggal_tagihan', $bulanTagihan)
                    ->whereYear('tanggal_tagihan', $tahunTagihan)
                    ->first();

                // dd($cekTagihan);


                if ($cekTagihan == null) {
                    // simpan data
                    Model::create($dataTagihan);
                }
            }
        }

        // 6. simpan notifikasi database untuk tagihan
        // 7. kirim pesan WA
        // 8. redirect back()


        flash('Data tagihan berhasil disimpan')->success();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $tagihan = Model::with('siswa')->where('siswa_id', $request->siswa_id)
            ->whereMonth('tanggal_tagihan', $request->bulan)
            ->whereYear('tanggal_tagihan', $request->tahun)
            ->get();

        dd($tagihan);
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
