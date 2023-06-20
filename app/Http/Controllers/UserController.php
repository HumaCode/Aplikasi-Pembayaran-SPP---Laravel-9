<?php

namespace App\Http\Controllers;

use App\Models\User as Model;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $viewIndex      = 'user_index';
    private $viewCreate     = 'user_form';
    private $viewEdit       = 'user_form';
    private $viewShow       = 'user_show';
    private $routePrefix    = 'user';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('operator.' . $this->viewIndex, [
            'models' => Model::where('akses', '<>', 'wali')
                ->latest()
                ->paginate(settings()->get('app_pagination', 50)),
            'title' => 'Data User',
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
            'title'     => 'Tambah Data User',
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
            'akses'     => 'required|in:operator,admin',
            'password'  => 'required'
        ]);

        $requestData['password'] = bcrypt($requestData['password']);
        Model::create($requestData);

        flash('Data berhasil ditambahkan');

        return back();
        // return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'title'     => 'Ubah Data User',
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
            'akses'     => 'required|in:operator,admin',
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

        // return redirect()->route('user.index');
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
