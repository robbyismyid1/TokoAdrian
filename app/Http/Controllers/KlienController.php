<?php

namespace App\Http\Controllers;

use App\Klien;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class KlienController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_klien'])->only('index');
        $this->middleware(['permission:create_klien'])->only('create');
        $this->middleware(['permission:update_klien'])->only('edit');
        $this->middleware(['permission:delete_klien'])->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cekKliens = Klien::count();
        if ($cekKliens < 1) {
            $kliens = Klien::all();
            $count = 0;
            $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
            $sumalert_stock = $alert_stock->count();
            return view('admin.klien.index', compact('kliens', 'count', 'alert_stock', 'sumalert_stock'));
        } else {
            $kliens = Klien::all();
            $data = DB::table('kliens')->latest()->first();
            $count = $data->id;
            $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
            $sumalert_stock = $alert_stock->count();
            return view('admin.klien.index', compact('kliens', 'count', 'alert_stock', 'sumalert_stock'));
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

    public function detailpenjualan($id)
    {
        $klien = Klien::find($id);
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.klien.saledetail', compact('klien', 'alert_stock', 'sumalert_stock'));
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
            'nama_klien' => 'required',
            'nik' => 'required|digits:16|unique:kliens,nik',
            'image' => 'required',
            'telepon' => 'required|max:13',
            'alamat' => 'required',

        ]);
        $request_data = $request->all();
        if ($request->image) {
            Image::make($request->image)
                ->resize(700, 500, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(
                    public_path(
                        'uploads/klien_images/' .
                            $request->image->hashName()
                    )
                );
            $request_data['image'] = $request->image->hashName();
        }
        Klien::create($request_data);
        toastr()->success('Berhasil membuat Klien', 'Dibuat!');
        if (!$request->ajax()) {
            return redirect()->route('klien.index');
        }
    }

    public function createinsale(Request $request)
    {
        $request->validate([
            'nama_klien' => 'required',
            'nik' => 'required|digits:16|unique:kliens,nik',
            'image' => 'required',
            'telepon' => 'required|max:13',
            'alamat' => 'required',

        ]);
        $request_data = $request->all();
        if ($request->image) {
            Image::make($request->image)
                ->resize(700, 500, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(
                    public_path(
                        'uploads/klien_images/' .
                            $request->image->hashName()
                    )
                );
            $request_data['image'] = $request->image->hashName();
        }
        Klien::create($request_data);
        toastr()->success('Berhasil membuat Klien', 'Dibuat!');
        if (!$request->ajax()) {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function show(Klien $klien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function edit(Klien $klien)
    {
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.klien.edit', compact('klien', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Klien $klien)
    {
        $request->validate([
            'nama_klien' => 'required',
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('kliens')->ignore($klien->id)
            ],
            'image' => 'image',
            'telepon' => 'required|max:13',
            'alamat' => 'required',

        ]);
        $request_data = $request->all();
        if ($request->image) {
            if ($klien->image != 'product.png') {
                Storage::disk('public_uploads')->delete(
                    '/klien_images/' . $klien->image
                );
            }
            Image::make($request->image)
                ->resize(700, 500, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(
                    public_path(
                        'uploads/klien_images/' .
                            $request->image->hashName()
                    )
                );
            $request_data['image'] = $request->image->hashName();
        }
        $klien->update($request_data);
        toastr()->success('Berhasil mengubah Klien', 'Diubah!');
        return redirect()->route('klien.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Klien  $klien
     * @return \Illuminate\Http\Response
     */
    public function destroy(Klien $klien)
    {
        if ($klien->image != 'product.png') {
            Storage::disk('public_uploads')->delete(
                '/klien_images/' . $klien->image
            );
        }
        $klien->delete();
        toastr()->info('Berhasil menghapus Klien', 'Dihapus!');
        return redirect()->route('klien.index');
    }
}
