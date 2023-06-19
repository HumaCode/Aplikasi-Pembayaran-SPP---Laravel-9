<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Biaya as Model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BiayaController extends Controller
{
    private $viewIndex      = 'biaya_index';
    private $viewCreate     = 'biaya_form';
    private $viewEdit       = 'biaya_form';
    private $viewShow       = 'biaya_show';
    private $routePrefix    = 'biaya';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // pencarian
        if ($request->filled('q')) {
            $models = Model::with('user')->whereNull('parent_id')->search($request->q)->paginate(50);
        } else {
            $models = Model::with('user')->whereNull('parent_id')->latest()->paginate(50);
        }

        return view('operator.' . $this->viewIndex, [
            'models'        => $models,
            'title'         => 'Data Biaya',
            'routePrefix'   => $this->routePrefix,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $biaya = new Model();
        if ($request->filled('parent_id')) {
            $biaya = Model::with('childern')->findOrFail($request->parent_id);
        }


        $data = [
            'parentData'    => $biaya,
            'model'         => new Model(),
            'method'        => 'POST',
            'route'         => $this->routePrefix . '.store',
            'button'        => 'Simpan Data',
            'title'         => 'Tambah Data Biaya',
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBiayaRequest $request)
    {
        Model::create($request->validated());
        flash('Data berhasil ditambahkan');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('operator.' . $this->viewShow, [
        //     'model' => Model::findOrFail($id),
        //     'title' => 'Detail Siswa',
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model'     => Model::findOrFail($id),
            'method'    => 'PUT',
            'route'     => [$this->routePrefix . '.update', $id],
            'button'    => 'Ubah Data',
            'title'     => 'Ubah Data Biaya',
        ];

        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBiayaRequest $request, $id)
    {
        $model = Model::findOrFail($id);

        $model->fill($request->validated());
        $model->save();

        flash('Data berhasil diubah');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::findOrFail($id);

        if ($model->siswa->count() >= 1) {
            flash('Data gagal dihapus, karena memiliki relasi ke tabel siswa.')->error();
            return back();
        }

        if ($model->childern->count() >= 1) {
            flash('Data tidak bisa dihapus, karena masih memiliki item biaya. Silahkan hapus item biaya terlebih dahulu.')->error();
            return back();
        }

        $model->delete();

        flash('Data berhasil dihapus')->success();
        return back();
    }

    public function deleteItem($id)
    {
        $model = Model::findOrFail($id);

        $model->delete();

        flash('Data berhasil dihapus')->success();
        return back();
    }
}
