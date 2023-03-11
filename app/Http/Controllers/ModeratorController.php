<?php

namespace App\Http\Controllers;

use View;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $karyawans = User::whereRoleIs('employer')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($query) use ($request) {
                return $query
                    ->where('name', 'like', '%' . $request->search . '%')
                    ->orwhere(
                        'username',
                        'like',
                        '%' . $request->search . '%'
                    );
            });
        })->get();
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.moderator.index', compact('karyawans', 'alert_stock', 'sumalert_stock'));
    }

    public function profile()
    {
        $profile = Auth::user();
        $allprofilepermission = $profile->allPermissions();
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.moderator.profile', compact('profile', 'allprofilepermission', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.moderator.create', compact('alert_stock', 'sumalert_stock'));
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
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1'
        ]);
        $request_data = $request->except([
            'password',
            'password_confirmation',
            'permissions',
            'image'
        ]);
        $request_data['password'] = bcrypt($request->password);
        if ($request->image) {
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(
                    public_path(
                        'uploads/moderator_images/' .
                            $request->image->hashName()
                    )
                );
            $request_data['image'] = $request->image->hashName();
        }
        $moderator = User::create($request_data);
        $moderator->attachRole('employer');
        $moderator->syncPermissions($request->permissions);
        toastr()->success('Berhasil membuat Karyawan', 'Dibuat!');
        return redirect()->route('karyawan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $moderator)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $karyawan)
    {
        $alert_stock = DB::table('produks')->where('stok', '<=', 'minstok')->get();
        $sumalert_stock = $alert_stock->count();
        return view('admin.moderator.edit', compact('karyawan', 'alert_stock', 'sumalert_stock'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $karyawan)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($karyawan->id)
            ],
            'image' => 'image',
            'permissions' => 'required|min:1'
        ]);
        $request_data = $request->except(['permissions', 'image']);
        if ($request->image) {
            if ($karyawan->image != 'default.png') {
                Storage::disk('public_uploads')->delete(
                    '/moderator_images/' . $karyawan->image
                );
            }
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(
                    public_path(
                        'uploads/moderator_images/' .
                            $request->image->hashName()
                    )
                );
            $request_data['image'] = $request->image->hashName();
        }
        $karyawan->update($request_data);
        $karyawan->syncPermissions($request->permissions);
        toastr()->success('Berhasil mengubah Karyawan', 'Diubah!');
        return redirect()->route('karyawan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $karyawan)
    {
        if ($karyawan->image != 'default.png') {
            Storage::disk('public_uploads')->delete(
                '/moderator_images/' . $karyawan->image
            );
        }

        $karyawan->delete();
        toastr()->info('Berhasil menghapus Karyawan', 'Dihapus!');
        return redirect()->back();
    }
}
