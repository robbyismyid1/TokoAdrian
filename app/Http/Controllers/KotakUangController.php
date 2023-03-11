<?php

namespace App\Http\Controllers;

use App\Penjualan;
use App\Pembelian;
use App\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KotakUangController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_kotakuang'])->only('index');
        $this->middleware(['permission:create_kotakuang'])->only('create');
        $this->middleware(['permission:update_kotakuang'])->only('edit');
        $this->middleware(['permission:delete_kotakuang'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uangpenjualan = Penjualan::orderBy('created_at', 'DESC')->get();
        $uangpembelian = Pembelian::orderBy('created_at', 'DESC')->get();
        $uangpengeluaran = Pengeluaran::orderBy('created_at', 'DESC')->get();

        $totaluangpenjualan = collect($uangpenjualan)->sum('dibayar');
        $totaluanghutangpenjualan = collect($uangpenjualan)->sum('due');
        $totaluangpembelian = collect($uangpembelian)->sum('dibayar');
        $totaluanghutangpembelian = collect($uangpembelian)->sum('due');
        $totaluangpengeluaran = collect($uangpengeluaran)->sum('harga_pengeluaran');

        $totalkotakuang = $totaluangpenjualan - $totaluangpembelian - $totaluangpengeluaran;

        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.kotak.index', compact('uangpenjualan', 'uangpembelian', 'uangpengeluaran', 'totaluangpenjualan', 'totaluangpembelian', 'totaluanghutangpenjualan', 'totaluanghutangpembelian', 'totaluangpengeluaran', 'totalkotakuang', 'alert_stock', 'sumalert_stock'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
