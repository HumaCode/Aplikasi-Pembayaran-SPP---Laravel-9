<?php

namespace App\Http\Controllers;

use App\Models\Siswa as Model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    private $viewIndex      = 'siswa_index';
    private $viewCreate     = 'siswa_form';
    private $viewEdit       = 'siswa_form';
    private $viewShow       = 'siswa_show';
    private $routePrefix    = 'siswa';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('operator.' . $this->viewIndex, [
            'models'        => Model::latest()->paginate(50),
            'title'         => 'Data Siswa',
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
        $data = [
            'model'     => new User(),
            'method'    => 'POST',
            'route'     => $this->routePrefix . '.store',
            'button'    => 'Simpan Data',
            'title'     => 'Tambah Data Siswa',
            'wali'      => User::where('akses', 'wali')->pluck('name', 'id'),
        ];

        return view('operator.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'wali_id'   => 'nullable',
            'nama'      => 'required',
            'nisn'      => 'required|unique:siswas',
            'jurusan'   => 'required',
            'kelas'     => 'required',
            'angkatan'  => 'required',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:5000'
        ]);

        if ($request->hasFile('foto')) {
            $requestData['foto'] = $request->file('foto')->store('public');
        }

        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        }

        $requestData['user_id'] = auth()->user()->id;

        Model::create($requestData);

        flash('Data berhasil ditambahkan');

        return back();
        // return redirect()->route('/wali');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('operator.' . $this->viewShow, [
            'model' => Model::findOrFail($id),
            'title' => 'Detail Siswa',
        ]);
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
            'title'     => 'Ubah Data Siswa',
            'wali'      => User::where('akses', 'wali')->pluck('name', 'id'),
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
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'wali_id'   => 'nullable',
            'nama'      => 'required',
            'nisn'      => 'required|unique:siswas,nisn,' . $id,
            'jurusan'   => 'required',
            'kelas'     => 'required',
            'angkatan'  => 'required',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:5000'
        ]);

        $model = Model::findOrFail($id);

        if ($request->hasFile('foto')) {

            if ($model->foto != null) {
                // unlink
                Storage::delete($model->foto);
            }

            $requestData['foto'] = $request->file('foto')->store('public');
        }

        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'ok';
        }

        $requestData['user_id'] = auth()->user()->id;

        $model->fill($requestData);
        $model->save();

        flash('Data berhasil diubah');

        // return redirect()->route('operator.wali');
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
        // return auth()->user()->id;
        $model = Model::findOrFail($id);

        if ($model->foto != null) {
            // unlink
            Storage::delete($model->foto);
        }

        $model->delete();

        flash('Data berhasil dihapus');
        return back();
    }
}
