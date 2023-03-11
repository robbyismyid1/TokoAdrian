<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_kategori'])->only('index');
        $this->middleware(['permission:create_kategori'])->only('create');
        $this->middleware(['permission:update_kategori'])->only('edit');
        $this->middleware(['permission:delete_kategori'])->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cekKategoris = Kategori::count();
        if ($cekKategoris < 1) {
            $kategoris = Kategori::all();
            $count = 0;
            $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
            $sumalert_stock = $alert_stock->count();
            return view('admin.kategori.index', compact('kategoris', 'count', 'alert_stock', 'sumalert_stock'));
        } else {
            $kategoris = Kategori::all();
            $kategori = DB::table('kategoris')->latest()->first();
            $count = $kategori->id;
            $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
            $sumalert_stock = $alert_stock->count();
            return view('admin.kategori.index', compact('kategoris', 'count', 'alert_stock', 'sumalert_stock'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.kategori.create');
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
            'kode_kategori' => 'required|unique:kategoris,kode_kategori',

        ]);
        Kategori::create($request->all());
        toastr()->success('Berhasil membuat Kategori', 'Dibuat!');
        return redirect()->route('kategori.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kategori  $katrgori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.kategori.edit', compact('kategori', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategoris,kode_kategori,' . $kategori->id,

        ]);
        $kategori->update($request->all());
        toastr()->success('Berhasil mengubah Kategori', 'Diubah!');
        return redirect()->route('kategori.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->produk->count() == 0) {
            $kategori->delete();
            toastr()->info('Berhasil menghapus Kategori', 'Dihapus!');
            return redirect()->route('kategori.index');
        } else {
            $kategori->delete();
            return redirect()->route('kategori.index');
        }
    }
    
}
