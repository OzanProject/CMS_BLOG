@extends('layouts.admin')

@section('header', 'Read Message')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0">Message Details</h6>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-light"><i class="fa fa-arrow-left me-2"></i>Back to Inbox</a>
        </div>

        <div class="mb-4 pb-4 border-bottom border-light">
            <h4 class="text-white custom-h4">{{ $message->subject ?? 'No Subject' }}</h4>
            <div class="d-flex justify-content-between mt-3 text-muted">
                <div>
                     <span>From: <strong class="text-white">{{ $message->name }}</strong> &lt;{{ $message->email }}&gt;</span>
                </div>
                <div>
                    <i class="fa fa-clock-o me-1"></i> {{ $message->created_at->format('d M Y, H:i') }}
                </div>
            </div>
        </div>

        <div class="message-body mb-5" style="white-space: pre-wrap; font-size: 1.1rem; line-height: 1.6;">{{ $message->message }}</div>

        <div class="d-flex gap-2">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-primary"><i class="fa fa-envelope me-2"></i>Reply via Email</a>
            
            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash me-2"></i>Delete Message</button>
            </form>
        </div>
    </div>
</div>

<style>
    .custom-h4 { line-height: 1.4; }
</style>
@endsection
