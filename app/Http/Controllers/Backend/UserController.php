<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penggunas = User::where('role', 'super-admin')->latest()->paginate(10)->withQueryString();
        return view('backend.pengguna.index', compact('penggunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|alpha_num|min:8',
        ]);

        $item = new User();
        $item->name = $request->name;
        $item->username = $request->username;
        $item->email = $request->email;
        $item->password = Hash::make($request->password);
        $item->save();

        return back()->with('success', 'Sukses, 1 Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'required|alpha_num|min:8',
        ]);

        $item = User::findOrFail($id);
        $item->name = $request->name;
        $item->username = $request->username;
        $item->email = $request->email;
        $item->password = Hash::make($request->password);
        $item->update();

        return back()->with('success', 'Sukses, 1 Data berhasil perbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = User::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }

    public function cariPengguna(Request $request)
    {
        $keyword = $request->input('keyword');
        // Menggunakan Query Builder untuk mencari pengguna
        $penggunas = User::where('role', 'super-admin')
            ->where(function ($query) use ($keyword) {
                $query->where('id', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('username', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->paginate(10)->withQueryString();

        return view('backend.pengguna.index', compact('penggunas'));
    }
}
