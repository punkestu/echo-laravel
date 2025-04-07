<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController
{
    public function index(Request $request)
    {
        $filter_type = $request->input('filter_type');
        $search = $request->input('search');
        $items = Item::with('itemTypes');
        if ($filter_type) {
            $items = $items->whereHas('itemTypes', function ($query) use ($filter_type) {
                $query->where('item_types.id', $filter_type);
            });
        }
        if ($search) {
            $items = $items->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }
        $items = $items->get();
        $itemtypes = ItemType::all();
        return view('dashboard.item.index', [
            'items' => $items,
            'itemtypes' => $itemtypes,
            'filter' => [
                'type' => $filter_type,
            ],
            'search' => $search,
        ]);
    }

    public function create()
    {
        $itemtypes = ItemType::all();
        return view('dashboard.item.create', [
            'itemtypes' => $itemtypes,
        ]);
    }

    public function edit($id)
    {
        $itemtypes = ItemType::all();
        $item = Item::with('itemTypes')->find($id);
        return view('dashboard.item.edit', ['item' => $item, 'itemtypes' => $itemtypes]);
    }

    public function store(Request $request)
    {
        $validation = validator($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'types' => 'required|array',
            'types.*' => 'exists:item_types,id',
            'qty' => 'required|integer|min:1',
            'good_qty' => 'required|integer|min:0',
            'bad_qty' => 'required|integer|min:0',
            'rent_qty' => 'required|integer|min:0',
            'base_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'description.string' => 'Deskripsi harus berupa string',
            'thumb.image' => 'File harus berupa gambar',
            'thumb.mimes' => 'Format gambar tidak valid',
            'thumb.max' => 'Ukuran gambar maksimal 2MB',
            'types.required' => 'Tipe tidak boleh kosong',
            'types.array' => 'Tipe harus berupa array',
            'types.*.exists' => 'Tipe tidak valid',
            'qty.required' => 'Jumlah tidak boleh kosong',
            'qty.integer' => 'Jumlah harus berupa angka',
            'qty.min' => 'Jumlah minimal 1',
            'good_qty.required' => 'Jumlah baik tidak boleh kosong',
            'good_qty.integer' => 'Jumlah baik harus berupa angka',
            'good_qty.min' => 'Jumlah baik minimal 0',
            'bad_qty.required' => 'Jumlah buruk tidak boleh kosong',
            'bad_qty.integer' => 'Jumlah buruk harus berupa angka',
            'bad_qty.min' => 'Jumlah buruk minimal 0',
            'rent_qty.required' => 'Jumlah sewa tidak boleh kosong',
            'rent_qty.integer' => 'Jumlah sewa harus berupa angka',
            'rent_qty.min' => 'Jumlah sewa minimal 0',
            'base_price.required' => 'Harga dasar tidak boleh kosong',
            'base_price.numeric' => 'Harga dasar harus berupa angka',
            'base_price.min' => 'Harga dasar minimal 0',
            'price.required' => 'Harga tidak boleh kosong',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal 0',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Gagal menambahkan item!'
            ])->withErrors($validation)->withInput();
        }

        DB::beginTransaction();
        // Logic to store the item
        $newitem = new Item();
        $newitem->name = $request->name;
        $newitem->description = $request->description;
        if ($request->hasFile('thumb')) {
            $newitem->thumb_url = $request->file('thumb')->store('images/items', 'public');
        } else {
            $newitem->thumb_url = null;
        }
        $newitem->qty = $request->qty;
        $newitem->good_qty = $request->good_qty;
        $newitem->bad_qty = $request->bad_qty;
        $newitem->rent_qty = $request->rent_qty;
        $newitem->base_price = $request->base_price;
        $newitem->price = $request->price;
        $newitem->save();
        $newitem->itemTypes()->attach($request->types);
        DB::commit();
        return redirect()->route('dashboard.item')->with('alert', [
            'type' => 'success',
            'message' => 'Item berhasil ditambahkan.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $validation = validator($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'types' => 'required|array',
            'types.*' => 'exists:item_types,id',
            'qty' => 'required|integer|min:1',
            'good_qty' => 'required|integer|min:0',
            'bad_qty' => 'required|integer|min:0',
            'rent_qty' => 'required|integer|min:0',
            'base_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Nama harus berupa string',
            'name.max' => 'Nama maksimal 255 karakter',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'description.string' => 'Deskripsi harus berupa string',
            'thumb.image' => 'File harus berupa gambar',
            'thumb.mimes' => 'Format gambar tidak valid',
            'thumb.max' => 'Ukuran gambar maksimal 2MB',
            'types.required' => 'Tipe tidak boleh kosong',
            'types.array' => 'Tipe harus berupa array',
            'types.*.exists' => 'Tipe tidak valid',
            'qty.required' => 'Jumlah tidak boleh kosong',
            'qty.integer' => 'Jumlah harus berupa angka',
            'qty.min' => 'Jumlah minimal 1',
            'good_qty.required' => 'Jumlah baik tidak boleh kosong',
            'good_qty.integer' => 'Jumlah baik harus berupa angka',
            'good_qty.min' => 'Jumlah baik minimal 0',
            'bad_qty.required' => 'Jumlah buruk tidak boleh kosong',
            'bad_qty.integer' => 'Jumlah buruk harus berupa angka',
            'bad_qty.min' => 'Jumlah buruk minimal 0',
            'rent_qty.required' => 'Jumlah sewa tidak boleh kosong',
            'rent_qty.integer' => 'Jumlah sewa harus berupa angka',
            'rent_qty.min' => 'Jumlah sewa minimal 0',
            'base_price.required' => 'Harga dasar tidak boleh kosong',
            'base_price.numeric' => 'Harga dasar harus berupa angka',
            'base_price.min' => 'Harga dasar minimal 0',
            'price.required' => 'Harga tidak boleh kosong',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga minimal 0',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Gagal memperbarui item!'
            ])->withErrors($validation)->withInput();
        }

        DB::beginTransaction();
        // Logic to update the item
        $item = Item::find($id);
        $item->name = $request->name;
        $item->description = $request->description;
        if ($request->hasFile('thumb')) {
            $item->thumb_url = $request->file('thumb')->store('images/items', 'public');
        }
        $item->qty = $request->qty;
        $item->good_qty = $request->good_qty;
        $item->bad_qty = $request->bad_qty;
        $item->rent_qty = $request->rent_qty;
        $item->base_price = $request->base_price;
        $item->price = $request->price;
        $item->save();
        $item->itemTypes()->sync($request->types);
        DB::commit();

        return redirect()->route('dashboard.item')->with('alert', [
            'type' => 'success',
            'message' => 'Item berhasil diperbarui.',
        ]);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        // Logic to delete the item
        $item = Item::find($id);
        if ($item) {
            $item->itemTypes()->detach();
            $item->delete();
        }
        DB::commit();
        return redirect()->route('dashboard.item')->with('alert', [
            'type' => 'success',
            'message' => 'Item berhasil dihapus.',
        ]);
    }
}
