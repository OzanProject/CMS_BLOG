@extends('layouts.admin')

@section('header', 'Inbox')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <form id="bulkDeleteForm" action="{{ route('admin.messages.bulk-destroy') }}" method="POST">
            @csrf
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">All Messages</h6>
                <button type="submit" id="deleteBtn" class="btn btn-primary d-none" onclick="return confirm('Hapus semua pesan yang dipilih?')">
                    <i class="fa fa-trash me-2"></i>Hapus Terpilih (<span id="selectedCount">0</span>)
                </button>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col"><input type="checkbox" id="selectAll" class="form-check-input"></th>
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
                            <td><input type="checkbox" name="ids[]" value="{{ $message->id }}" class="form-check-input msg-checkbox"></td>
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
                                
                                <button type="button" class="btn btn-sm btn-primary delete-single" data-id="{{ $message->id }}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No messages found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
        
        {{-- Single delete form helper --}}
        <form id="singleDeleteForm" action="" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Select All Checkbox
    $('#selectAll').on('click', function() {
        $('.msg-checkbox').prop('checked', this.checked);
        toggleDeleteButton();
    });

    // Individual Checkbox Click
    $('.msg-checkbox').on('change', function() {
        toggleDeleteButton();
        
        // Update Select All state
        if ($('.msg-checkbox:checked').length == $('.msg-checkbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    function toggleDeleteButton() {
        const selectedCount = $('.msg-checkbox:checked').length;
        $('#selectedCount').text(selectedCount);
        
        if (selectedCount > 0) {
            $('#deleteBtn').removeClass('d-none');
        } else {
            $('#deleteBtn').addClass('d-none');
        }
    }

    // Single Delete click
    $('.delete-single').on('click', function() {
        const id = $(this).data('id');
        if (confirm('Delete this message?')) {
            const form = $('#singleDeleteForm');
            form.attr('action', '/admin/messages/' + id);
            form.submit();
        }
    });
});
</script>
@endpush
@endsection
