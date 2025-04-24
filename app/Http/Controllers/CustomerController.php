<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController
{
    public function api_getCustomers(Request $request)
    {
        $name = $request->input('name');
        $phone = $request->input('phone');

        $customers = \App\Models\Customer::with([]);
        if ($name) {
            $customers = $customers->where('name', 'like', '%' . $name . '%');
        } else if ($phone) {
            $customers = $customers->where('phone', 'like', '%' . $phone . '%');
        }
        $customers = $customers->get();
        return response()->json([
            'data' => $customers,
            'message' => 'success',
            'meta' => [
                'total' => $customers->count(),
                'name' => $name,
                'phone' => $phone,
            ]
        ]);
    }

    public function index()
    {
        $customers = \App\Models\Customer::all();
        return view('dashboard.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('dashboard.customer.create');
    }

    public function edit($id)
    {
        $customer = \App\Models\Customer::findOrFail($id);
        return view('dashboard.customer.edit', compact('customer'));
    }

    public function store(Request $request)
    {
        $customer = new \App\Models\Customer();
        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->save();

        return redirect()->route('dashboard.customer')->with('success', 'Customer created successfully.');
    }

    public function update(Request $request, $id)
    {
        $customer = \App\Models\Customer::findOrFail($id);
        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->save();

        return redirect()->route('dashboard.customer')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $customer = \App\Models\Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('dashboard.customer')->with('success', 'Customer deleted successfully.');
    }
}
