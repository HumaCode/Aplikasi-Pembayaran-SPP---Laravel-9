<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User as Model;
use App\Models\User;
use Illuminate\Http\Request;

class WaliController extends Controller
{
    private $viewIndex      = 'wali_index';
    private $viewCreate     = 'user_form';
    private $viewEdit       = 'user_form';
    private $viewShow       = 'wali_show';
    private $routePrefix    = 'wali';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('operator.' . $this->viewIndex, [
            'models' => Model::wali()
                ->latest()
                ->paginate(settings()->get('app_pagination', 50)),
            'title' => 'Data Wali Murid',
            'routePrefix' => $this->routePrefix,
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
            'title'     => 'Tambah Data Wali Murid',
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
            'name'      => 'required',
            'email'     => 'required|unique:users',
            'nohp'      => 'required|unique:users',
            'password'  => 'required'
        ]);

        $requestData['password'] = bcrypt($requestData['password']);
        $requestData['akses'] = 'wali';

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
            'siswa' => Siswa::whereNull('wali_id')->pluck('nama', 'id'),
            'model' => Model::with('siswa')->wali()->where('id', $id)->firstOrFail(),
            'title' => 'Detail Wali Murid',
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
            'model'     => User::findOrFail($id),
            'method'    => 'PUT',
            'route'     => [$this->routePrefix . '.update', $id],
            'button'    => 'Ubah Data',
            'title'     => 'Ubah Data Wali Murid',
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
            'name'      => 'required',
            'email'     => 'required|unique:users,email,' . $id,
            'nohp'      => 'required|unique:users,nohp,' . $id,
            'password'  => 'nullable'
        ]);

        $model = Model::findOrFail($id);
        if ($requestData['password'] == "") {
            unset($requestData['password']);
        } else {
            $requestData['password'] = bcrypt($requestData['password']);
        }

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

        $model = User::findOrFail($id);

        if ($model->id == 1 || $model->id == auth()->user()->id) {
            flash('Data tidak dapat dihapus')->error();
            return back();
        }

        $model->delete();

        flash('Data berhasil dihapus');
        return back();
    }
}
