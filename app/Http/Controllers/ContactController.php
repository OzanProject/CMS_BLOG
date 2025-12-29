<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Page;

class ContactController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', 'contact')->first();
        // Fallback title/content if no dynamic page exists
        $title = $page->title ?? __('frontend.contacts');
        $content = $page->body ?? '';
        
        $settings = \App\Models\Configuration::pluck('value', 'key');
        
        return view('frontend.contact', compact('title', 'content', 'settings', 'page'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create($request->all());

        return back()->with('success', __('frontend.message_sent'));
    }
}
