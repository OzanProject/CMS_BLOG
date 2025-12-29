@extends('layouts.admin')

@section('header', 'Inbox')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">All Messages</h6>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Date</th>
                        <th scope="col">Name</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'fw-bold' }}" style="{{ $message->is_read ? '' : 'background-color: rgba(255,255,255,0.05);' }}">
                        <td>{{ $message->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->subject ?? '(No Subject)' }}</td>
                        <td>
                            @if($message->is_read)
                                <span class="badge bg-outline-secondary text-muted">Read</span>
                            @else
                                <span class="badge bg-primary">Unread</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-info" href="{{ route('admin.messages.show', $message->id) }}"><i class="fa fa-eye"></i></a>
                            
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No messages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection
