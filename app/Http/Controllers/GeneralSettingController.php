<?php

namespace App\Http\Controllers;

use View;
use App\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class GeneralSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_pengaturan'])->only('index');
        $this->middleware(['permission:create_pengaturan'])->only('create');
        $this->middleware(['permission:update_pengaturan'])->only('edit');
        $this->middleware(['permission:delete_pengaturan'])->only('destroy');

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
    public function index(GeneralSetting $generalsetting)
    {
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.settings.index', compact('alert_stock', 'sumalert_stock'));
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
            'nama_toko' => 'required',
            'deskripsi' =>'required',
            'telepon'=>'required',
            'alamat' => 'required',
            'tanggal_mulai' => 'required',
            'image' => 'image',
        ]);
        $id = $request->input('id');
        $general_setting = GeneralSetting::findOrFail($id);
        $request_data = $request->all();
        if ($request->image) {
            if ($general_setting->image != 'logo_default.png') {
                Storage::disk('public_uploads')->delete(
                    '/settings/' . $general_setting->image
                );
            }
            Image::make($request->image)
                ->resize(160, 160, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(
                    public_path(
                        'uploads/settings/' . $request->image->hashName()
                    )
                );
            $request_data['image'] = $request->image->hashName();
        }
        $general_setting->update($request_data);
        toastr()->success('Berhasil mengubah Pengatura toko', 'Diubah!');
        return redirect()->back();
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
