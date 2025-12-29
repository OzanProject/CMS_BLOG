@extends('layouts.admin')

@section('header', __('comments.title'))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <h6 class="mb-0">{{ __('menu.comments') }}</h6>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.comments.index', ['status' => 'all']) }}" class="btn btn-sm {{ $status == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                    {{ __('dashboard.show_all') }} <span class="badge bg-white text-dark ms-1">{{ $counts['all'] }}</span>
                </a>
                <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="btn btn-sm {{ $status == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                    {{ __('comments.pending') }} <span class="badge bg-white text-dark ms-1">{{ $counts['pending'] }}</span>
                </a>
                <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}" class="btn btn-sm {{ $status == 'approved' ? 'btn-success' : 'btn-outline-success' }}">
                    {{ __('comments.approved') }} <span class="badge bg-white text-dark ms-1">{{ $counts['approved'] }}</span>
                </a>
                <a href="{{ route('admin.comments.index', ['status' => 'spam']) }}" class="btn btn-sm {{ $status == 'spam' ? 'btn-danger' : 'btn-outline-danger' }}">
                    {{ __('comments.spam') }} <span class="badge bg-white text-dark ms-1">{{ $counts['spam'] }}</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-start" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0 text-nowrap">
                <thead>
                    <tr class="text-white">
                        <th scope="col">{{ __('comments.author') }}</th>
                        <th scope="col">{{ __('comments.comment') }}</th>
                        <th scope="col">{{ __('comments.article') }}</th>
                        <th scope="col">{{ __('common.status') }}</th>
                        <th scope="col">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold me-2" style="width: 35px; height: 35px;">
                                    {{ substr($comment->name, 0, 1) }}
                                </div>
                                <div class="text-start">
                                    <div class="fw-bold">{{ $comment->name }}</div>
                                    <small class="text-muted d-block">{{ $comment->email }}</small>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 300px;" title="{{ $comment->body }}">
                                {{ Str::limit($comment->body, 80) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.articles.edit', $comment->article_id) }}" class="text-primary text-decoration-none">
                                {{ Str::limit($comment->article->title, 25) }}
                            </a>
                        </td>
                        <td>
                            @if($comment->status == 'pending')
                                <span class="badge bg-warning text-dark">{{ __('comments.pending') }}</span>
                            @elseif($comment->status == 'approved')
                                <span class="badge bg-success">{{ __('comments.approved') }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('comments.spam') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($comment->status !== 'approved')
                                <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="btn btn-sm btn-success" title="{{ __('users.approve') ?? 'Approve' }}">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                
                                @if($comment->status !== 'spam')
                                <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="spam">
                                    <button type="submit" class="btn btn-sm btn-warning" title="{{ __('comments.spam') }}">
                                        <i class="fa fa-ban"></i>
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('{{ __('common.confirm_delete') }}');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-primary" title="{{ __('common.delete') }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">{{ __('common.no_data') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $comments->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
