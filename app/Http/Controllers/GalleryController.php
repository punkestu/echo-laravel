<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController
{
    public function user_index() {
        // Fetch all galleries from the database order by priority
        $galleries = \App\Models\Gallery::get_cached();
        // Return the view with the galleries data
        return view('user.gallery', compact('galleries'));
    }
    public function index() {
        // Fetch all galleries from the database
        $galleries = \App\Models\Gallery::all();
        // Return the view with the galleries data
        return view('dashboard.gallery.index', compact('galleries'));
    }

    public function create() {
        // Return the view to create a new gallery
        return view('dashboard.gallery.create');
    }

    public function store(Request $request) {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'priority' => 'integer|min:0'
        ]);

        // Create a new gallery entry in the database
        $gallery = new \App\Models\Gallery();
        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');
        $gallery->image_url = $request->file('image')->store('images', 'public');
        $gallery->priority = $request->input('priority', 0);
        $gallery->save();

        // Redirect to the galleries index with a success message
        return redirect()->route('dashboard.gallery')->with('alert', [
            'type' => 'success',
            'message' => 'Galeri berhasil ditambahkan'
        ]);
    }

    public function edit($id) {
        // Fetch the gallery entry from the database
        $gallery = \App\Models\Gallery::findOrFail($id);
        // Return the view to edit the gallery
        return view('dashboard.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, $id) {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'priority' => 'integer|min:0'
        ]);

        // Fetch the gallery entry from the database
        $gallery = \App\Models\Gallery::findOrFail($id);
        // Update the gallery entry in the database
        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');
        if ($request->hasFile('image')) {
            // Store the new image and update the image_url
            $gallery->image_url = $request->file('image')->store('images', 'public');
        }
        $gallery->priority = $request->input('priority', 0);
        $gallery->save();

        // Redirect to the galleries index with a success message
        return redirect()->route('dashboard.gallery')->with('alert', [
            'type' => 'success',
            'message' => 'Galeri berhasil diubah.'
        ]);
    }

    public function destroy($id) {
        // Fetch the gallery entry from the database
        $gallery = \App\Models\Gallery::findOrFail($id);
        // Delete the gallery entry from the database
        $gallery->delete();

        // Redirect to the galleries index with a success message
        return redirect()->route('dashboard.gallery')->with('alert', [
            'type' => 'success',
            'message' => 'Galeri berhasil dihapus.'
        ]);
    }
}
