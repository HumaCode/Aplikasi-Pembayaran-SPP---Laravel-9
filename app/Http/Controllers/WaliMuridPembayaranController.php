<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankSekolah;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\User;
use App\Models\WaliBank;
use App\Notifications\PembayaranNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Notification;

class WaliMuridPembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::where('wali_id', auth()->user()->id)
            ->latest()
            ->orderBy('tanggal_konfirmasi', 'desc')
            ->paginate(settings()->get('app_pagination', 50));

        $data = [
            'models'    => $pembayaran,
            'title'     => 'DATA PEMBAYARAN',
        ];

        return view('wali.pembayaran_index', $data);
    }

    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();

        return view('wali.pembayaran_show', [
            'model' => $pembayaran,
        ]);
    }

    public function create(Request $request)
    {
        // return $request->bank_sekolah_id;

        $data = [
            'tagihan'           => Tagihan::waliSIswa()->findOrFail($request->tagihan_id),
            'model'             => new Pembayaran(),
            'method'            => 'POST',
            'route'             => 'wali.pembayaran.store',
            'listBankSekolah'   => BankSekolah::pluck('nama_bank', 'id'),
            'listBank'          => Bank::pluck('nama_bank', 'id'),
            'listWaliBank'      => WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id'),
        ];

        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        }

        $data['url'] = route('wali.pembayaran.create', [
            'tagihan_id'        => $request->tagihan_id,
        ]);


        return view('wali.pembayaran_form', $data);
    }

    public function store(Request $request)
    {
        if ($request->wali_bank_id == '' && $request->nomor_rekening == '') {
            flash('Silahkan pilih bank pengirim')->error();
            return back();
        }


        if ($request->nama_rekening != '' && $request->nomor_rekening != '') {
            $bankId                 = $request->bank_id;
            $bank                   = Bank::findOrFail($bankId);


            if ($request->filled('simpan_data_rekening')) {
                $requestDataBank = $request->validate([
                    'nama_rekening'    => 'required',
                    'nomor_rekening'   => 'required',
                ]);

                $waliBank = WaliBank::firstOrCreate(
                    $requestDataBank,
                    [
                        'nama_rekening' => $requestDataBank['nama_rekening'],
                        'wali_id'       => Auth::user()->id,
                        'kode'          => $bank->sandi_bank,
                        'nama_bank'     => $bank->nama_bank,
                    ]
                );
            }
        } else {
            $waliBankId     = $request->wali_bank_id;
            $waliBank       = WaliBank::findOrFail($waliBankId);
        }

        // validasi agar tidak ngirim tagihan berulang2
        $jumlahDibayar      = str_replace('.', '', $request->jumlah_dibayar);
        $validasiPembayaran = Pembayaran::where('jumlah_dibayar', $jumlahDibayar)
            ->where('tagihan_id', $request->tagihan_id)
            ->first();

        // dd($validasiPembayaran);

        if ($validasiPembayaran != null) {
            flash('Data pembayaran ini sudah ada, dan akan segera di konfirmasi oleh Operator.')->error();
            return back();
        }


        $request->validate([
            'tanggal_bayar'     => 'required',
            'jumlah_dibayar'    => 'required',
            'bukti_bayar'       => 'required|image|mimes:jpg,png,jpeg|max:5048',
        ]);


        $buktiBayar = $request->file('bukti_bayar')->store('public');

        $dataPembayaran = [
            'bank_sekolah_id'   => $request->bank_sekolah_id,
            'wali_bank_id'      => $waliBank->id,
            'tagihan_id'        => $request->tagihan_id,
            'wali_id'           => auth()->user()->id,
            'tanggal_bayar'     => $request->tanggal_bayar,
            'jumlah_dibayar'    => str_replace('.', '', $jumlahDibayar),
            'bukti_bayar'       => $buktiBayar,
            'metode_pembayaran' => 'transfer',
            'user_id'           => 0,
        ];

        DB::beginTransaction();

        try {
            $pembayaran = Pembayaran::create($dataPembayaran);

            $userOperator = User::where('akses', 'operator')->get();
            // dd($userOperator);

            Notification::send($userOperator, new PembayaranNotification($pembayaran));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            flash('Gagal menyimpan data pembayaran ' . $th->getMessage())->error();
            return back();
        }


        flash('Pembayaran berhasil disimpan dan akan segera dikonfirmasi oleh operator')->success();
        return redirect()->route('wali.pembayaran.show', $pembayaran->id);
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->tanggal_konfirmasi != null) {
            flash('Data pembayaran ini sudah di konfirmasi, tidak bisa di hapus');
            return back();
        }

        $imagePath = $pembayaran->bukti_bayar;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
            echo "Gambar berhasil dihapus.";
        } else {
            echo "Gambar tidak ditemukan.";
        }

        $pembayaran->delete();

        flash('Data pembayaran berhasil dihapus')->success();
        return redirect()->route('wali.pembayaran.index');
    }
}
