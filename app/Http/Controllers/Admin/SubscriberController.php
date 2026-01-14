<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscribers = Subscriber::latest()->paginate(20);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Subscriber deleted successfully.');
    }

    public function compose()
    {
        return view('admin.subscribers.compose');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $subscribers = Subscriber::all();
        $count = 0;
        $errors = [];

        foreach ($subscribers as $subscriber) {
            try {
                // Using Mail::to with configured SMTP
                \Illuminate\Support\Facades\Mail::to($subscriber->email)
                    ->send(new \App\Mail\NewsletterEmail($request->subject, $request->message));
                $count++;
            } catch (\Exception $e) {
                // Log and capture error
                \Illuminate\Support\Facades\Log::error('Newsletter Send Error to ' . $subscriber->email . ': ' . $e->getMessage());
                $errors[] = $e->getMessage();
            }
        }

        if ($count == 0 && count($subscribers) > 0) {
            // All failed
            return back()->with('error', 'Failed to send emails. Error: ' . ($errors[0] ?? 'Unknown Error'));
        }

        return redirect()->route('admin.subscribers.index')
            ->with('success', "Newsletter sent to $count subscribers successfully.");
    }
}
