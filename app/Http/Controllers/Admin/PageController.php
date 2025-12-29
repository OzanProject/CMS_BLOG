<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()->get();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'status' => 'required|boolean',
        ]);

        $slug = \Illuminate\Support\Str::slug($request->title);
        // Ensure unique slug
        if (Page::where('slug', $slug)->exists()) {
            $slug .= '-' . \Illuminate\Support\Str::random(5);
        }

        Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->input('content'),
            'meta_title' => $request->meta_title ?? $request->title,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Not used in admin
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.form', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'status' => 'required|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->input('content'),
            'meta_title' => $request->meta_title ?? $request->title,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
        ];

        if ($request->title !== $page->title) {
             $data['slug'] = \Illuminate\Support\Str::slug($request->title);
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return redirect()->back()->with('success', 'Page deleted successfully!');
    }
}
