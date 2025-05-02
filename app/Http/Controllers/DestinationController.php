<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController
{
    public function user_index()
    {
        $destinations = Destination::get_cached();
        return view('user.destination', [
            'destinations' => $destinations,
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::get_cached();
        return view('dashboard.destination.index', [
            'destinations' => $destinations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.destination.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = validator([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_url' => 'required|url',
            'tags' => 'nullable|array',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with("alert", [
                "type" => "error",
                "message" => "Validation failed",
            ])->withErrors($validation)->withInput();
        }

        if ($request->hasFile('thumb')) {
            $thumb_url = $request->file('thumb')->store('images/destination', 'public');
        }

        $request->merge([
            'thumb_url' => $thumb_url ?? null,
        ]);
        Destination::create($request->only([
            'name',
            'address',
            'city',
            'country',
            'description',
            'thumb_url',
            'map_url',
            'tags',
        ]));
        Destination::sync_cache();

        return redirect()->route('destinations.index')->with('alert', [
            'type' => 'success',
            'message' => 'Destination created successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        return response('This feature is not ready yet.', 501);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        return view('dashboard.destination.edit', [
            'destination' => $destination,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $validation = validator([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_url' => 'required|url',
            'tags' => 'nullable|array',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with("alert", [
                "type" => "error",
                "message" => "Validation failed",
            ])->withErrors($validation)->withInput();
        }

        if ($request->hasFile('thumb')) {
            $thumb_url = $request->file('thumb')->store('images/destination', 'public');
        }

        $request->merge([
            'thumb_url' => $thumb_url ?? $destination->thumb_url,
        ]);
        $destination->update($request->only([
            'name',
            'address',
            'city',
            'country',
            'description',
            'thumb_url',
            'map_url',
            'tags',
        ]));
        Destination::sync_cache();

        return redirect()->route('destinations.index')->with('alert', [
            'type' => 'success',
            'message' => 'Destination updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();
        Destination::sync_cache();
        return redirect()->route('destinations.index')->with('alert', [
            'type' => 'success',
            'message' => 'Destination deleted successfully.',
        ]);
    }
}
