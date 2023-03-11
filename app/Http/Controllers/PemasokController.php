<?php

namespace App\Http\Controllers;

use App\Pemasok;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_pemasok'])->only('index');
        $this->middleware(['permission:create_pemasok'])->only('create');
        $this->middleware(['permission:update_pemasok'])->only('edit');
        $this->middleware(['permission:delete_pemasok'])->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cekPemasoks = Pemasok::count();
        if ($cekPemasoks < 1) {
            $pemasoks = Pemasok::all();
            $count = 0;
            $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
            $sumalert_stock = $alert_stock->count();
            return view('admin.pemasok.index', compact('pemasoks', 'count', 'alert_stock', 'sumalert_stock'));
        } else {
            $pemasoks = Pemasok::all();
            $data = DB::table('pemasoks')->latest()->first();
            $count = $data->id;
            $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
            $sumalert_stock = $alert_stock->count();
            return view('admin.pemasok.index', compact('pemasoks', 'count', 'alert_stock', 'sumalert_stock'));
        }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    public function detailpembelian($id)
    {
        $pemasok = Pemasok::find($id);
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.pemasok.purchasedetail', compact('pemasok', 'alert_stock', 'sumalert_stock'));
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
            'nama_pemasok' => 'required',
            'telepon' => 'required|max:13',
            'alamat' => 'required',

        ]);
        Pemasok::create($request->all());
        toastr()->success('Berhasil membuat Klien', 'Dibuat!');
        if (!$request->ajax()) {
            return redirect()->route('pemasok.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function show(Pemasok $pemasok)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemasok $pemasok)
    {
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.pemasok.edit', compact('pemasok', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pemasok $pemasok)
    {
        $request->validate([
            'nama_pemasok' => 'required',
            'telepon' => 'required|max:13',
            'alamat' => 'required',

        ]);
        $pemasok->update($request->all());
        toastr()->success('Berhasil mengubah Pemasok', 'Diubah!');
        return redirect()->route('pemasok.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pemasok  $pemasok
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();
        toastr()->info('Berhasil menghapus Pemasok', 'Dihapus!');
        return redirect()->route('pemasok.index');
    }
}
