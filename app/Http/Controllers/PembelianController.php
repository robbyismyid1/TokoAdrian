<?php

namespace App\Http\Controllers;

use View;
use App\Pembelian;
use App\Pemasok;
use App\Produk;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_pembelian'])->only('index');
        $this->middleware(['permission:create_pembelian'])->only('create');
        $this->middleware(['permission:update_pembelian'])->only('edit');
        $this->middleware(['permission:delete_pembelian'])->only('destroy');

        $general_settings = DB::table('general_settings')->where('id', 1)->get();
        foreach ($general_settings as $key => $general_setting) {
            $store_id = $general_setting->id;
            $store_name = $general_setting->nama_toko;
            $activity = $general_setting->deskripsi;
            $phone = $general_setting->telepon;
            $address = $general_setting->alamat;
            $start_day = $general_setting->tanggal_mulai;
            $logo = $general_setting->image;
        }

        View::share('store_id', $store_id);
        View::share('store_name', $store_name);
        View::share('activity', $activity);
        View::share('phone', $phone);
        View::share('address', $address);
        View::share('start_day', $start_day);
        View::share('logo', $logo);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemasoks = Pemasok::all();
        $kategoris = Kategori::all();
        $produks = Produk::all();
        $pembelians = Pembelian::orderBy('nomor_pembelian', 'desc')->get();
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.pembelian.index', compact('pemasoks', 'kategoris', 'produks', 'pembelians', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pemasoks = Pemasok::all();
        $kategoris = Kategori::all();
        $cekProduks = Produk::count();
        if ($cekProduks < 1) {
            $produk = Produk::all();
            $count = 0;
        } else {
            $produk = Produk::all();
            $data = DB::table('produks')->latest()->first();
            $count = $data->id;
        }
        $produks = Produk::all();
        $pembelians = Pembelian::all();
        
        if (Pembelian::all()->last() == null) {
            $purchase_number = 'PN' . ' : ' . '1' . ' / ' . date('d') . '/' . date('m') . '/' . date('Y');
        } else {
            $lastpurchaseNumber = Pembelian::all()->last()->nomor_pembelian;
            $lastNumber = substr($lastpurchaseNumber,4,-13);
            $purchase_number = 'PN' .' : ' . str_pad($lastNumber + 1, 0, 0, STR_PAD_LEFT) . ' / ' . date('d') . '/' . date('m') . '/' . date('Y');
        }
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();

        return view('admin.pembelian.create', compact('purchase_number', 'pemasoks', 'count', 'kategoris', 'produks', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_pembelian' => 'required',
            'total' => 'required',
            'diskon' => 'required',
            'jumlah_total' => 'required',
            'dibayar' => 'required',
            'credit' => 'required',
            'status' => 'required',
            'pemasok_id' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);
        $data = $request->all();

        $pembelians = Pembelian::create([
            'nomor_pembelian' => $data['nomor_pembelian'],
            'total' => $data['total'],
            'diskon' => $data['diskon'],
            'jumlah_total' => $data['jumlah_total'],
            'dibayar' => $data['dibayar'],
            'due' => $data['credit'],
            'status' => $data['status'],
            'pemasok_id' => $data['pemasok_id'],

        ]);
        $dat = $data['product'];
        $qty = $request->get('quantity');
        
        $attach_data = [];
        for ($i = 0; $i < count($dat); $i++) {
            $attach_data[$dat[$i]] = ['quantity' => $qty[$i]];
        }
        $pembelians->produk()->attach($attach_data);

        for ($i = 0; $i < count($dat); $i++) {
            $produk = Produk::find($dat[$i]);
            $produk->stok = $produk->stok + ($qty[$i]);
            $produk->save();
        }
        toastr()->success('Berhasil menambah Pembelian', 'Ditambah!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        $pembelian_produk = $pembelian->produk;
        $pembelian_pemasok = $pembelian->pemasok;
        $pembelians = Pembelian::findorfail($pembelian)->first();
        $i = 0;
        return view('admin.pembelian.show', compact('pembelian_produk', 'pembelian_pemasok', 'pembelian', 'i'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pembelian  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        $pemasoksel = $pembelian->pemasok;
        $pemasoks = Pemasok::all();
        $kategoris = Kategori::all();
        $produks = Produk::all();
        $cekProduks = Produk::count();
        if ($cekProduks < 1) {
            $count = 0;
        } else {
            $data = DB::table('produks')->latest()->first();
            $count = $data->id;
        }
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.pembelian.edit', compact('pembelian', 'pemasoksel', 'pemasoks', 'kategoris', 'produks', 'count', 'alert_stock', 'sumalert_stock'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'nomor_pembelian' => 'required',
            'total' => 'required',
            'diskon' => 'required',
            'jumlah_total' => 'required',
            'dibayar' => 'required',
            'credit' => 'required',
            'status' => 'required',
            'pemasok_id' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);

        foreach ($pembelian->produk as $key => $produk) {
            $produk->update([
                'stok' => $produk->stok - $produk->pivot->quantity
            ]);
        }
        $pembelian->delete();

        $data = $request->all();

        $purchase_update = Pembelian::create([
            'nomor_pembelian' => $data['nomor_pembelian'],
            'total' => $data['total'],
            'diskon' => $data['diskon'],
            'jumlah_total' => $data['jumlah_total'],
            'dibayar' => $data['dibayar'],
            'due' => $data['credit'],
            'status' => $data['status'],
            'pemasok_id' => $data['pemasok_id'],

        ]);
        $dat = $data['product'];
        $qty = $request->get('quantity');

        $attach_data = [];
        for ($i = 0; $i < count($dat); $i++) {
            $attach_data[$dat[$i]] = ['quantity' => $qty[$i]];
        }
        $purchase_update->produk()->attach($attach_data);
        
        for ($i = 0; $i < count($dat); $i++) {
            $produk = Produk::find($dat[$i]);
            $produk->stok = $produk->stok + ($qty[$i]);
            $produk->save();
        }
        toastr()->success('Berhasil mengubah Pembelian', 'Diubah!');
        return redirect()->route('pembelian.index');
    }
    
    public function hutangsaya(Request $request, $id)
    {
        $credits = Pembelian::find($id);
        $paid = $request->dibayar;
        $due = $request->hutang;
        $pdue = $request->bayar;
        if ($pdue == $due) {
            $credits->due =  $due -  $pdue;
            $credits->dibayar = $paid + $pdue;
            $credits->status = "dibayar";
            $credits->save();
            toastr()->success('Berhasil melunasi Hutang', 'Lunas!');
            return redirect()->route('pembelian.index');
        } elseif ($pdue < $due) {
            $credits->due =  $due -  $pdue;
            $credits->dibayar = $paid + $pdue;
            $credits->status = "hutang";
            $credits->save();
            toastr()->info('Berhasil membayar Hutang', 'Dibayar!');
            return redirect()->route('pembelian.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */

    public function destroy(Pembelian $pembelian)
    {
        foreach ($pembelian->produk as $key => $produk) {
            $produk->update([
                'stok' => $produk->stok - $produk->pivot->quantity
            ]);
        }
        $pembelian->delete();
        toastr()->info('Berhasil Menghapus Pembelian', 'Dihapus!');
        return redirect()->back();
    }
}
