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
}
