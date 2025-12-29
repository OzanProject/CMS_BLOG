@extends('layouts.admin')

@section('header', __('users.title'))

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">{{ __('menu.users') }}</h6>
            <div class="d-flex gap-2">
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-none d-md-flex">
                    <input class="form-control bg-dark border-0 me-2" type="search" name="search" value="{{ request('search') }}" placeholder="{{ __('common.search') }}...">
                    <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                </form>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetUserForm()">
                    <i class="fa fa-plus me-2"></i>{{ __('common.add') }}
                </button>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-start" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0 text-nowrap">
                <thead>
                    <tr class="text-white">
                        <th scope="col">{{ __('users.details') }}</th>
                        <th scope="col">{{ __('users.role') }}</th>
                        <th scope="col">{{ __('common.status') }}</th>
                        <th scope="col">{{ __('users.joined_date') }}</th>
                        <th scope="col">{{ __('common.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white me-3 {{ $user->role == 1 ? 'bg-primary' : 'bg-success' }}" style="width: 40px; height: 40px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <small>{{ $user->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->role == 1)
                                <span class="badge bg-primary">{{ __('users.admin') }}</span>
                            @else
                                <span class="badge bg-success">{{ __('users.writer') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">{{ __('users.active') }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ __('users.pending') }}</span>
                            @endif
                        </td>
                        <td>
                            {{ $user->created_at->format('M d, Y') }}
                            <br>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->is_active)
                                        <button type="submit" class="btn btn-sm btn-outline-warning me-2" title="{{ __('users.ban') }}">
                                            <i class="fa fa-ban"></i>
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-success me-2" title="{{ __('users.approve') }}">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    @endif
                                </form>
                            @endif

                            <button class="btn btn-sm btn-info me-2" onclick="editUser({{ json_encode($user) }})">
                                <i class="fa fa-edit"></i>
                            </button>

                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('common.confirm_delete') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            @endif
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
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@include('admin.users.modal')

@push('scripts')
<script>
    function resetUserForm() {
        document.getElementById('userModalLabel').innerText = '{{ __('common.add') }}';
        document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('role').value = '2';
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
        document.getElementById('saveBtn').innerText = '{{ __('common.save') }}';
        document.getElementById('passwordHelp').classList.add('d-none');
    }

    function editUser(user) {
        document.getElementById('userModalLabel').innerText = '{{ __('common.edit') }}';
        document.getElementById('userForm').action = `/admin/users/${user.id}`;
        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('role').value = user.role;
        document.getElementById('password').value = ''; // Don't show password
        document.getElementById('password_confirmation').value = '';
        document.getElementById('saveBtn').innerText = '{{ __('common.save') }}';
        document.getElementById('passwordHelp').classList.remove('d-none');
        
        var myModal = new bootstrap.Modal(document.getElementById('userModal'));
        myModal.show();
    }
</script>
@endpush
@endsection
