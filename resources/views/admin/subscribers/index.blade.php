@extends('layouts.admin')

@section('header', 'Newsletter Subscribers')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">All Subscribers</h6>
            <div>
                <a href="{{ route('admin.subscribers.compose') }}" class="btn btn-success btn-sm me-2"><i class="fa fa-envelope me-2"></i>Compose Email</a>
                <button class="btn btn-primary btn-sm" onclick="copyToClipboard()"><i class="fa fa-copy me-2"></i>Copy All Emails</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Date Subscribed</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                    <tr>
                        <td>{{ $subscriber->created_at->format('d M Y H:i') }}</td>
                        <td class="email-item">{{ $subscriber->email }}</td>
                        <td>
                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">No subscribers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $subscribers->links() }}
        </div>
    </div>
</div>

<!-- All Emails Hidden Container -->
<textarea id="all-emails" class="d-none">{{ $subscribers->pluck('email')->implode(', ') }}</textarea>

<script>
    function copyToClipboard() {
        var copyText = document.getElementById("all-emails");
        copyText.classList.remove("d-none");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        navigator.clipboard.writeText(copyText.value).then(() => {
            alert("Copied all emails to clipboard!");
            copyText.classList.add("d-none");
        });
    }
</script>
@endsection
