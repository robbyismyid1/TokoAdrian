<?php

namespace App\Http\Controllers;

use Response;
use App\Produk;
use App\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProdukController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_produk'])->only('index');
        $this->middleware(['permission:create_produk'])->only('create');
        $this->middleware(['permission:update_produk'])->only('edit');
        $this->middleware(['permission:delete_produk'])->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cekProduks = Produk::count();
        if ($cekProduks < 1) {
            $produk = Produk::all();
            $kategori = Kategori::all();
            $kategoris = Kategori::all();
            $produks = Produk::when($request->search, function ($q) use ($request) {
                return $q->where('nama_produk', 'like', '%' . $request->search . '%');
            })->when($request->kategori_id, function ($q) use ($request) {
                return $q->where('kategori_id', $request->kategori_id);
            })->latest()->get();
            $count = 0;
            $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
            $sumalert_stock = $alert_stock->count();
        } else {
            $produk = Produk::all();
            $kategori = Kategori::all();
            $kategoris = Kategori::all();
            $data = DB::table('produks')->latest()->first();
            $produks = Produk::when($request->search, function ($q) use ($request) {
                return $q->where('nama_produk', 'like', '%' . $request->search . '%');
            })->when($request->kategori_id, function ($q) use ($request) {
                return $q->where('kategori_id', $request->kategori_id);
            })->latest()->get();
            $count = $data->id;
            $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
            $sumalert_stock = $alert_stock->count();
        }
        return view('admin.produk.index', compact('produk', 'produks', 'kategori', 'kategoris', 'count', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'kategori_id' => 'required',
            'kode_produk' => 'required|unique:produks,kode_produk',
            'nama_produk' => 'required|unique:produks,nama_produk',
            'harga_pembelian' => 'required',
            'harga_penjualan' => 'required',
            'stok' => 'required',
            'minstok' => 'required',
            
        ]);
        $request_data = $request->all();
        if ($request->image) {
            Image::make($request->image)
                ->resize(160, 160, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(
                    public_path(
                        'uploads/product_images/' .
                            $request->image->hashName()
                    )
                );
            $request_data['image'] = $request->image->hashName();
        }
        Produk::create($request_data);
        toastr()->success('Berhasil membuat Produk', 'Dibuat!');
        if (!$request->ajax()) {
            return redirect()->route('produk.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }
    
    public function searchsale(Request $request)
    {
        if ($request->ajax()) {
            $produks = Produk::when($request->searchbyproduct, function ($q) use ($request) {
                return $q->where('nama_produk', 'like', '%' . $request->searchbyproduct . '%');
            })->get();
            return Response::json(array(
                'produks' => $produks,
            ));
        } else {
            $produks = Produk::all();
            return Response::json(array(
                'produks' => $produks,
            ));
        }
    }

    public function searchpurchase(Request $request)
    {
        if ($request->ajax()) {
            $produks = Produk::when($request->searchbyproduct, function ($q) use ($request) {
                return $q->where('nama_produk', 'like', '%' . $request->searchbyproduct . '%');
            })->get();
            return Response::json(array(
                'produks' => $produks,
            ));
        } else {
            $produks = Produk::all();
            return Response::json(array(
                'produks' => $produks,
            ));
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        $kategori = Kategori::all();
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.produk.edit', compact('kategori', 'produk', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'kategori_id' => 'required',
            'kode_produk' => [
                'required',
                Rule::unique('produks')->ignore($produk->id)
            ],
            'nama_produk' => [
                'required',
                Rule::unique('produks')->ignore($produk->id)
            ],
            'harga_pembelian' => 'required',
            'harga_penjualan' => 'required',
            'stok' => 'required',
            'minstok' => 'required',
            'image' => 'image',

        ]);
        $request_data = $request->all();
        if ($request->image) {
            if ($produk->image != 'product.png') {
                Storage::disk('public_uploads')->delete(
                    '/product_images/' . $produk->image
                );
            }
            Image::make($request->image)
                ->resize(160, 160, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(
                    public_path(
                        'uploads/product_images/' .
                            $request->image->hashName()
                    )
                );
            $request_data['image'] = $request->image->hashName();
        }
        $produk->update($request_data);
        toastr()->success('Berhasil mengubah Produk', 'Diubah!');
        return redirect()->route('produk.index');
    }

    public function updateprice(Request $request, $id)
    {
        $request->validate([
            'harga_pembelian' => 'required',
            'harga_penjualan' => 'required',
        ]);
        $hargaproduk = Produk::findOrFail($id);
        $hargaproduk->harga_pembelian = $request->harga_pembelian;
        $hargaproduk->harga_penjualan = $request->harga_penjualan;
        $hargaproduk->save();
        toastr()->success('Berhasil mengubah harga produk', 'Harga diubah!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        if ($produk->image != 'product.png') {
            Storage::disk('public_uploads')->delete(
                '/product_images/' . $produk->image
            );
        }
        $produk->delete();
        toastr()->info('Berhasil menghapus Produk', 'Dihapus!');
        return redirect()->route('produk.index');
    }
}
