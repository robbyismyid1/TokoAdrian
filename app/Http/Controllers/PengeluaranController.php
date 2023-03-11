<?php

namespace App\Http\Controllers;

use App\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_pengeluaran'])->only('index');
        $this->middleware(['permission:create_pengeluaran'])->only('create');
        $this->middleware(['permission:update_pengeluaran'])->only('edit');
        $this->middleware(['permission:delete_pengeluaran'])->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluarans = Pengeluaran::all();
        $totalpengeluaran = collect($pengeluarans)->sum('harga_pengeluaran');
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.pengeluaran.index', compact('pengeluarans', 'totalpengeluaran', 'alert_stock', 'sumalert_stock'));
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
        $request->validate([
            'nama_pengeluaran' => 'required',
            'deskripsi_pengeluaran' => 'required',
            'harga_pengeluaran' => 'required',

        ]);
        Pengeluaran::create($request->all());
        toastr()->success('Berhasil menambah Pengeluaran', 'Ditambah!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Spending  $spending
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {

        $request->validate([
            'nama_pengeluaran' => 'required',
            'deskripsi_pengeluaran' => 'required',
            'harga_pengeluaran' => 'required',

        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);
        $pengeluaran->nama_pengeluaran = $request->nama_pengeluaran;
        $pengeluaran->deskripsi_pengeluaran = $request->deskripsi_pengeluaran;
        $pengeluaran->harga_pengeluaran = $request->harga_pengeluaran;

        $pengeluaran->save();
        toastr()->success('Berhasil mengubah Pengeluaran', 'Diubah!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        toastr()->info('Berhasil menghapus Pengeluaran', 'Dihapus!');
        return redirect()->back();
    }
}
