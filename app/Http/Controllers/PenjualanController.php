<?php

namespace App\Http\Controllers;

use View;
use App\Penjualan;
use App\Klien;
use App\Produk;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_penjualan'])->only('index');
        $this->middleware(['permission:create_penjualan'])->only('create');
        $this->middleware(['permission:update_penjualan'])->only('edit');
        $this->middleware(['permission:delete_penjualan'])->only('destroy');

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
        $kliens = Klien::all();
        $kategoris = Kategori::all();
        $produks = Produk::all();
        $penjualans = Penjualan::orderBy('nomor_penjualan', 'desc')->get();
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.penjualan.index', compact('kliens', 'kategoris', 'produks', 'penjualans', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kliens = Klien::all();
        $kategoris = Kategori::all();
        $produks = Produk::all();
        $penjualans = Penjualan::all();
        
        if (Penjualan::all()->last() == null) {
            $sale_number = 'SN' . ' : ' . '1' . ' / ' . date('d') . '/' . date('m') . '/' . date('Y');
        } else {
            $lastsaleNumber = Penjualan::all()->last()->nomor_penjualan;
            $lastNumber = substr($lastsaleNumber,4,-13);
            $sale_number = 'SN' .' : ' . str_pad($lastNumber + 1, 0, 0, STR_PAD_LEFT) . ' / ' . date('d') . '/' . date('m') . '/' . date('Y');
        }
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.penjualan.create', compact('sale_number', 'kliens', 'kategoris', 'produks', 'alert_stock', 'sumalert_stock'));
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
            'nomor_penjualan' => 'required',
            'total' => 'required',
            'diskon' => 'required',
            'jumlah_total' => 'required',
            'dibayar' => 'required',
            'credit' => 'required',
            'status' => 'required',
            'klien_id' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);
        $data = $request->all();

        $penjualans = Penjualan::create([
            'nomor_penjualan' => $data['nomor_penjualan'],
            'total' => $data['total'],
            'diskon' => $data['diskon'],
            'jumlah_total' => $data['jumlah_total'],
            'dibayar' => $data['dibayar'],
            'due' => $data['credit'],
            'status' => $data['status'],
            'klien_id' => $data['klien_id'],

        ]);
        $dat = $data['product'];
        $qty = $request->get('quantity');

        $attach_data = [];
        for ($i = 0; $i < count($dat); $i++) {
            $attach_data[$dat[$i]] = ['quantity' => $qty[$i]];
        }
        $penjualans->produk()->attach($attach_data);

        for ($i = 0; $i < count($dat); $i++) {
            $produk = Produk::find($dat[$i]);
            if ($produk->stok == 0) {
                toastr()->info('Stok Produk Ini Kosong', 'Info!');
            } else {
                $produk->stok = $produk->stok - ($qty[$i]);
                $produk->save();
            }
        }
        toastr()->success('Berhasil menambah Penjualan', 'Ditambah!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        $penjualan_produk = $penjualan->produk;
        $penjualan_klien = $penjualan->klien;
        $penjualans = Penjualan::findorfail($penjualan)->first();
        $i = 0;
        return view('admin.penjualan.show', compact('penjualan_produk', 'penjualan_klien', 'penjualan', 'i'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        $clientsel = $penjualan->klien;
        $kliens = Klien::all();
        $kategoris = Kategori::all();
        $produks = Produk::all();
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.penjualan.edit', compact('penjualan', 'clientsel', 'kliens', 'kategoris', 'produks', 'alert_stock', 'sumalert_stock'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'nomor_penjualan' => 'required',
            'total' => 'required',
            'diskon' => 'required',
            'jumlah_total' => 'required',
            'dibayar' => 'required',
            'credit' => 'required',
            'status' => 'required',
            'klien_id' => 'required',
            'product' => 'required',
            'quantity' => 'required',
        ]);

        foreach ($penjualan->produk as $key => $produk) {
            $produk->update([
                'stok' => $produk->stok + $produk->pivot->quantity
            ]);
        }
        $penjualan->delete();

        $data = $request->all();

        $sale_update = Penjualan::create([
            'nomor_penjualan' => $data['nomor_penjualan'],
            'total' => $data['total'],
            'diskon' => $data['diskon'],
            'jumlah_total' => $data['jumlah_total'],
            'dibayar' => $data['dibayar'],
            'due' => $data['credit'],
            'status' => $data['status'],
            'klien_id' => $data['klien_id'],

        ]);
        $dat = $data['product'];
        $qty = $request->get('quantity');

        $attach_data = [];
        for ($i = 0; $i < count($dat); $i++) {
            $attach_data[$dat[$i]] = ['quantity' => $qty[$i]];
        }

        $sale_update->produk()->attach($attach_data);

        for ($i = 0; $i < count($dat); $i++) {
            $produk = Produk::find($dat[$i]);
            if ($produk->stok == 0) {
                toastr()->info('Stok produk ini kosong', 'Kosong!');
            } else {
                $produk->stok = $produk->stok - ($qty[$i]);
                $produk->save();
            }
        }
        toastr()->success('Berhasil mengubah Penjualan', 'Ditambah!');
        return redirect()->route('penjualan.index');
    }
    
    public function hutangklien(Request $request, $id)
    {
        $credits = Penjualan::find($id);
        $paid = $request->dibayar;
        $due = $request->hutang;
        $pdue = $request->bayar;
        if ($pdue == $due) {
            $credits->due =  $due -  $pdue;
            $credits->dibayar = $paid + $pdue;
            $credits->status = "dibayar";
            $credits->save();
            toastr()->success('Berhasil melunasi Hutang', 'Lunas!');
            return redirect()->route('penjualan.index');
        } elseif ($pdue < $due) {
            $credits->due =  $due -  $pdue;
            $credits->dibayar = $paid + $pdue;
            $credits->status = "hutang";
            $credits->save();
            toastr()->info('Berhasil membayar Hutang', 'Dibayar!');
            return redirect()->route('penjualan.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */

    public function destroy(Penjualan $penjualan)
    {
        foreach ($penjualan->produk as $key => $produk) {
            $produk->update([
                'stok' => $produk->stok + $produk->pivot->quantity
            ]);
        }
        $penjualan->delete();
        toastr()->info('Berhasil Menghapus Penjualan', 'Dihapus!');
        return redirect()->back();
    }
}
