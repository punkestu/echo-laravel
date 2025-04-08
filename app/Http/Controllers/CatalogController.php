<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Http\Request;

class CatalogController
{
    public function user_index()
    {
        $search = request('search');
        $filter_type = request('filter_type');
        $catalogs = Catalog::with(['catalogItems' => function ($query) {
            $query->with('item');
        }]);
        if ($filter_type) {
            $catalogs = $catalogs->whereHas('catalogItems.item.itemTypes', function ($query) use ($filter_type) {
                $query->where('item_types.id', $filter_type);
            });
        }
        if ($search) {
            $catalogs = $catalogs->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        $catalogs = $catalogs->get();
        $itemtypes = ItemType::all();
        return view('user.catalog', [
            'catalogs' => $catalogs,
            'itemtypes' => $itemtypes,
            'search' => $search,
            'filter' => [
                'type' => $filter_type,
            ],
        ]);
    }
    public function index()
    {
        $search = request('search');
        $filter_type = request('filter_type');
        $catalogs = Catalog::with(['catalogItems' => function ($query) {
            $query->with('item');
        }]);
        if ($filter_type) {
            $catalogs = $catalogs->whereHas('catalogItems.item.itemTypes', function ($query) use ($filter_type) {
                $query->where('item_types.id', $filter_type);
            });
        }
        if ($search) {
            $catalogs = $catalogs->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }
        $catalogs = $catalogs->get();
        $itemtypes = ItemType::all();
        return view('dashboard.catalog.index', [
            'catalogs' => $catalogs,
            'itemtypes' => $itemtypes,
            'search' => $search,
            'filter' => [
                'type' => $filter_type,
            ],
        ]);
    }

    public function create()
    {
        $items = Item::all();
        return view('dashboard.catalog.create', [
            'items' => $items,
        ]);
    }

    public function edit($id)
    {
        $catalog = Catalog::with(['catalogItems' => function ($query) {
            $query->with('item');
        }])->find($id);
        $items = Item::all();
        return view('dashboard.catalog.edit', [
            'catalog' => $catalog,
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        $validation = validator($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'items' => 'required|array',
            'items.*' => 'exists:items,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ], [
            'name.required' => 'Nama catalog harus diisi.',
            'name.string' => 'Nama catalog harus berupa string.',
            'name.max' => 'Nama catalog tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Deskripsi catalog harus berupa string.',
            'thumb.image' => 'Gambar catalog harus berupa gambar.',
            'thumb.mimes' => 'Gambar catalog harus berupa file dengan ekstensi jpeg, png, jpg, atau gif.',
            'thumb.max' => 'Ukuran gambar catalog tidak boleh lebih dari 2MB.',
            'price.required' => 'Harga catalog harus diisi.',
            'price.numeric' => 'Harga catalog harus berupa angka.',
            'price.min' => 'Harga catalog tidak boleh kurang dari 0.',
            'items.required' => 'Item catalog harus diisi.',
            'items.array' => 'Item catalog harus berupa array.',
            'items.*.exists' => 'Item catalog tidak valid.',
            'qty.required' => 'Jumlah item catalog harus diisi.',
            'qty.array' => 'Jumlah item catalog harus berupa array.',
            'qty.*.required' => 'Jumlah item catalog harus diisi.',
            'qty.*.integer' => 'Jumlah item catalog harus berupa angka.',
            'qty.*.min' => 'Jumlah item catalog tidak boleh kurang dari 1.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Gagal menambahkan katalog!',
            ])->withErrors($validation)->withInput();
        }

        $newcatalog = new Catalog();
        $newcatalog->name = $request->name;
        $newcatalog->description = $request->description;
        $newcatalog->price = $request->price;
        if ($request->hasFile('thumb')) {
            $newcatalog->thumb_url = $request->file('thumb')->store('catalogs', 'public');
        }
        $newcatalog->save();
        foreach ($request->items as $index => $itemId) {
            $qty = $request->qty[$index];
            $newcatalog->items()->attach($itemId, ['qty' => $qty]);
        }

        return redirect()->route('dashboard.catalog')->with('alert', [
            'type' => 'success',
            'message' => 'Katalog berhasil ditambahkan!',
        ]);
    }

    public function update(Request $request, $id)
    {
        $validation = validator($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'items' => 'required|array',
            'items.*' => 'exists:items,id',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
        ], [
            'name.required' => 'Nama catalog harus diisi.',
            'name.string' => 'Nama catalog harus berupa string.',
            'name.max' => 'Nama catalog tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Deskripsi catalog harus berupa string.',
            'thumb.image' => 'Gambar catalog harus berupa gambar.',
            'thumb.mimes' => 'Gambar catalog harus berupa file dengan ekstensi jpeg, png, jpg, atau gif.',
            'thumb.max' => 'Ukuran gambar catalog tidak boleh lebih dari 2MB.',
            'price.required' => 'Harga catalog harus diisi.',
            'price.numeric' => 'Harga catalog harus berupa angka.',
            'price.min' => 'Harga catalog tidak boleh kurang dari 0.',
            'items.required' => 'Item catalog harus diisi.',
            'items.array' => 'Item catalog harus berupa array.',
            'items.*.exists' => 'Item catalog tidak valid.',
            'qty.required' => 'Jumlah item catalog harus diisi.',
            'qty.array' => 'Jumlah item catalog harus berupa array.',
            'qty.*.required' => 'Jumlah item catalog harus diisi.',
            'qty.*.integer' => 'Jumlah item catalog harus berupa angka.',
            'qty.*.min' => 'Jumlah item catalog tidak boleh kurang dari 1.'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Gagal memperbarui katalog!',
            ])->withErrors($validation)->withInput();
        }

        $catalog = Catalog::find($id);
        $catalog->name = $request->name;
        $catalog->description = $request->description;
        $catalog->price = $request->price;
        if ($request->hasFile('thumb')) {
            $catalog->thumb_url = $request->file('thumb')->store('catalogs', 'public');
        }
        $catalog->save();
        foreach ($request->items as $index => $itemId) {
            $qty = $request->qty[$index];
            $catalog->items()->syncWithoutDetaching([$itemId => ['qty' => $qty]]);
        }

        return redirect()->route('dashboard.catalog')->with('alert', [
            'type' => 'success',
            'message' => 'Katalog berhasil diperbarui!',
        ]);
    }

    public function destroy($id)
    {
        $catalog = Catalog::find($id);
        if ($catalog) {
            $catalog->items()->detach();
            $catalog->delete();
            return redirect()->route('dashboard.catalog')->with('alert', [
                'type' => 'success',
                'message' => 'Katalog berhasil dihapus!',
            ]);
        } else {
            return redirect()->route('dashboard.catalog')->with('alert', [
                'type' => 'error',
                'message' => 'Katalog tidak ditemukan!',
            ]);
        }
    }
}
