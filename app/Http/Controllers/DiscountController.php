<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscountController
{
    public function index()
    {
        $search = request('search');
        $discounts = \App\Models\Discount::with(['user', 'customer'])->get();
        return view('dashboard.discount.index', [
            'discounts' => $discounts,
            'search' => $search,
        ]);
    }

    public function create()
    {
        $customers = \App\Models\Customer::all();
        $users = \App\Models\User::all();
        return view('dashboard.discount.create', [
            'customers' => $customers,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validation = validator($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
        ], [
            'user_id.exists' => 'Member tidak ditemukan.',
            'customer_id.exists' => 'Customer tidak ditemukan.',
            'discount_percentage.numeric' => 'Diskon persen harus berupa angka.',
            'discount_percentage.min' => 'Diskon persen tidak boleh kurang dari 0.',
            'discount_percentage.max' => 'Diskon persen tidak boleh lebih dari 100.',
            'discount_amount.numeric' => 'Diskon nominal harus berupa angka.',
            'discount_amount.min' => 'Diskon nominal tidak boleh kurang dari 0.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with("alert", [
                "type" => "error",
                "message" => "Inputan salah.",
            ])->withErrors($validation)->withInput();
        }

        if (!$request->user_id && !$request->customer_id) {
            $validation = validator($request->all(), [
                'user_id' => 'required|exists:users,id',
                'customer_id' => 'required|exists:customers,id',
            ], [
                'user_id.required' => 'Pilih member/customer terlebih dahulu.',
                'customer_id.required' => 'Pilih member/customer terlebih dahulu.',
            ]);
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Silahkan pilih member/customer terlebih dahulu.',
            ])->withErrors($validation)->withInput();
        }
        if (!$request->discount_percentage && !$request->discount_amount) {
            $validation = validator($request->all(), [
                'discount_percentage' => 'required|numeric|min:0|max:100',
                'discount_amount' => 'required|numeric|min:0',
            ], [
                'discount_percentage.required' => 'Silahkan isi diskon persen/nominal terlebih dahulu.',
                'discount_amount.required' => 'Silahkan isi diskon persen/nominal terlebih dahulu.',
            ]);
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Silahkan isi diskon persen/nominal terlebih dahulu.',
            ])->withErrors($validation)->withInput();
        }
        if ($request->discount_percentage && $request->discount_amount) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Silahkan pilih salah satu antara diskon persen atau diskon nominal.',
            ]);
        }

        \App\Models\Discount::create([
            'user_id' => $request->user_id ?? null,
            'customer_id' => $request->customer_id ?? null,
            'discount_percentage' => $request->discount_percentage ?? null,
            'discount_amount' => $request->discount_amount ?? null,
        ]);

        return redirect()->route('dashboard.discount')->with('alert', [
            'type' => 'success',
            'message' => 'Berhasil menambahkan diskon.',
        ]);
    }

    public function edit($id)
    {
        $discount = \App\Models\Discount::with(['user', 'customer'])->findOrFail($id);
        $customers = \App\Models\Customer::all();
        $users = \App\Models\User::all();
        return view('dashboard.discount.edit', [
            'discount' => $discount,
            'customers' => $customers,
            'users' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validation = validator($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'customer_id' => 'nullable|exists:customers,id',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
        ], [
            'user_id.exists' => 'Member tidak ditemukan.',
            'customer_id.exists' => 'Customer tidak ditemukan.',
            'discount_percentage.required' => 'Diskon persen harus diisi.',
            'discount_percentage.numeric' => 'Diskon persen harus berupa angka.',
            'discount_percentage.min' => 'Diskon persen tidak boleh kurang dari 0.',
            'discount_percentage.max' => 'Diskon persen tidak boleh lebih dari 100.',
            'discount_amount.required' => 'Diskon nominal harus diisi.',
            'discount_amount.numeric' => 'Diskon nominal harus berupa angka.',
            'discount_amount.min' => 'Diskon nominal tidak boleh kurang dari 0.',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with("alert", [
                "type" => "error",
                "message" => "Inputan salah.",
            ])->withErrors($validation)->withInput();
        }

        if (!$request->user_id && !$request->customer_id) {
            $validation = validator($request->all(), [
                'user_id' => 'required|exists:users,id',
                'customer_id' => 'required|exists:customers,id',
            ], [
                'user_id.required' => 'Pilih member/customer terlebih dahulu.',
                'customer_id.required' => 'Pilih member/customer terlebih dahulu.',
            ]);
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Silahkan pilih member/customer terlebih dahulu.',
            ])->withErrors($validation)->withInput();
        }
        if (!$request->discount_percentage && !$request->discount_amount) {
            $validation = validator($request->all(), [
                'discount_percentage' => 'required|numeric|min:0|max:100',
                'discount_amount' => 'required|numeric|min:0',
            ], [
                'discount_percentage.required' => 'Silahkan isi diskon persen/nominal terlebih dahulu.',
                'discount_amount.required' => 'Silahkan isi diskon persen/nominal terlebih dahulu.',
            ]);
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Silahkan isi diskon persen/nominal terlebih dahulu.',
            ])->withErrors($validation)->withInput();
        }
        if ($request->discount_percentage && $request->discount_amount) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Silahkan pilih salah satu antara diskon persen atau diskon nominal.',
            ]);
        }

        $discount = \App\Models\Discount::findOrFail($id);
        $discount->update($request->all());

        return redirect()->route('dashboard.discount')->with('alert', [
            'type' => 'success',
            'message' => 'Berhasil memperbarui diskon.',
        ]);
    }

    public function destroy($id)
    {
        $discount = \App\Models\Discount::findOrFail($id);
        $discount->delete();

        return redirect()->route('dashboard.discount')->with('alert', [
            'type' => 'success',
            'message' => 'Berhasil menghapus diskon.',
        ]);
    }
}
