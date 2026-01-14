@extends('layouts.admin')

@section('header', 'Compose Newsletter')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Send Email to All Subscribers</h6>
                
                <form action="{{ route('admin.subscribers.send') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" name="subject" required placeholder="Newsletter Subject">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" rows="10" required placeholder="Write your newsletter content here..."></textarea>
                        <div class="form-text text-muted">You can use basic text. New lines will be preserved.</div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.subscribers.index') }}" class="btn btn-dark">Cancel</a>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to send this email to ALL subscribers?');">
                            <i class="fa fa-paper-plane me-2"></i> Send Broadcast
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
