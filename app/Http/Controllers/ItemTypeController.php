<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController
{
    public function index()
    {
        $itemtypes = ItemType::all();
        return view('dashboard.item-type.index', [
            'itemtypes' => $itemtypes,
        ]);
    }
    public function create()
    {
        return view('dashboard.item-type.create');
    }
    public function edit($id)
    {
        $itemtype = ItemType::find($id);
        return view('dashboard.item-type.edit', ['itemtype' => $itemtype]);
    }
    public function store(Request $request)
    {
        $validation = validator($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        ItemType::create([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.item-type')->with('success', 'Tipe berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $validation = validator($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $itemtype = ItemType::find($id);
        $itemtype->update([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.item-type')->with('success', 'Tipe berhasil diubah');
    }
    public function destroy($id)
    {
        $itemtype = ItemType::find($id);
        if ($itemtype) {
            $itemtype->delete();
            return redirect()->route('dashboard.item-type')->with('success', 'Tipe berhasil dihapus');
        } else {
            return redirect()->route('dashboard.item-type')->with('error', 'Tipe tidak ditemukan');
        }
    }
}
