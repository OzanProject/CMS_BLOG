@extends('layouts.admin')

@section('header', 'Compose Newsletter')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4 text-white">Send Email to All Subscribers</h6>

                    <form action="{{ route('admin.subscribers.send') }}" method="POST">
                        @csrf

                        <!-- Subject Field -->
                        <div class="mb-3">
                            <label class="form-label text-white">Subject</label>
                            <input type="text" class="form-control" name="subject" required
                                placeholder="Newsletter Subject">
                        </div>

                        <!-- Message Field -->
                        <div class="mb-3">
                            <label class="form-label text-white">Message</label>
                            <textarea class="form-control" name="message" rows="10" required
                                placeholder="Write your newsletter content here..."></textarea>
                            <div class="form-text text-muted">You can use basic text. New lines will be preserved.</div>
                        </div>

                        <!-- Actions: Cancel and Submit -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.subscribers.index') }}" class="btn btn-dark">Cancel</a>
                            <button type="submit" class="btn btn-primary" onclick="return confirmEmailSubmission();">
                                <i class="fa fa-paper-plane me-2"></i> Send Broadcast
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmEmailSubmission() {
                return confirm('Are you sure you want to send this email to ALL subscribers? This action is irreversible.');
            }
        </script>
    @endpush

@endsection