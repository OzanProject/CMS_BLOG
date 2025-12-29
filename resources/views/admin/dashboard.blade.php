@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
<!-- Welcome Banner -->
<div class="container-fluid pt-4 px-4">
    <div class="row">
        <div class="col-12">
            <div class="bg-secondary rounded p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 text-white">Welcome back, {{ auth()->user()->name }}! 👋</h4>
                    <p class="mb-0 text-muted">Here's what's happening with your blog today.</p>
                </div>
                <div class="text-end d-none d-md-block">
                    <h6 class="mb-0 text-white">{{ date('l, d F Y') }}</h6>
                    <small class="text-muted"><i class="fa fa-clock me-1"></i>Server Time</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Total Articles -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded p-4 d-flex align-items-center justify-content-between h-100 position-relative overflow-hidden group-hover">
                <div class="ms-3 z-index-1">
                    <p class="mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Total Articles</p>
                    <h3 class="mb-0 text-primary fw-bold">{{ $stats['total_articles'] ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-newspaper fa-lg text-primary"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Users -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded p-4 d-flex align-items-center justify-content-between h-100">
                <div class="ms-3">
                    <p class="mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Total Users</p>
                    <h3 class="mb-0 text-info fw-bold">{{ $stats['total_users'] ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-users fa-lg text-info"></i>
                </div>
            </div>
        </div>
        
        <!-- Total Comments -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded p-4 d-flex align-items-center justify-content-between h-100">
                <div class="ms-3">
                    <p class="mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Comments</p>
                    <h3 class="mb-0 text-success fw-bold">{{ $stats['total_comments'] ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-comments fa-lg text-success"></i>
                </div>
            </div>
        </div>
        
        <!-- Pending Actions -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded p-4 d-flex align-items-center justify-content-between h-100">
                <div class="ms-3">
                    <p class="mb-2 text-muted fw-bold text-uppercase" style="font-size: 0.8rem;">Pending</p>
                    <h3 class="mb-0 text-warning fw-bold">{{ $stats['pending_comments'] ?? 0 }}</h3>
                </div>
                <div class="icon-box bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="fa fa-clock fa-lg text-warning"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Left Column (Content Overview) -->
        <div class="col-lg-8">
            <!-- Chart Section -->
            <div class="bg-secondary rounded p-4 mb-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Content Distribution</h6>
                    <a href="#" class="text-muted"><i class="fa fa-chart-bar"></i></a>
                </div>
                <canvas id="content-chart" style="max-height: 250px;"></canvas>
            </div>

            <!-- Recent Articles -->
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Recent Published Articles</h6>
                    <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col">Title</th>
                                <th scope="col">Category</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latest_articles as $article)
                            <tr>
                                <td>{{ Str::limit($article->title, 40) }}</td>
                                <td><span class="badge bg-dark border border-secondary">{{ $article->category->name ?? 'None' }}</span></td>
                                <td>{{ $article->created_at->format('d M') }}</td>
                                <td><a class="btn btn-sm btn-primary" href="{{ route('admin.articles.edit', $article->id) }}"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted">No articles found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column (Sidebar Widgets) -->
        <div class="col-lg-4">
            
            <!-- Quick Actions -->
            <div class="bg-secondary rounded p-4 mb-4">
                <h6 class="mb-4">Quick Actions</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary text-start"><i class="fa fa-plus-circle me-2"></i> Write New Article</a>
                    @if(auth()->user()->role === 1)
                    <a href="{{ route('admin.users.create') }}" class="btn btn-outline-light text-start"><i class="fa fa-user-plus me-2"></i> Add New User</a>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-light text-start"><i class="fa fa-cog me-2"></i> Site Settings</a>
                    @endif
                </div>
            </div>

            <!-- Recent Comments -->
            <div class="bg-secondary rounded p-4 mb-4">
                <h6 class="mb-4">Recent Comments</h6>
                @forelse($recent_comments as $comment)
                <div class="d-flex align-items-start border-bottom border-dark pb-3 mb-3">
                    <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0 text-white" style="font-size: 0.9rem;">{{ $comment->name }}</h6>
                            <small class="text-muted" style="font-size: 0.7rem;">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <small class="text-muted d-block mb-1">on {{ Str::limit($comment->article->title, 20) }}</small>
                        <p class="mb-0 text-white-50 small fst-italic">"{{ Str::limit($comment->body, 50) }}"</p>
                    </div>
                </div>
                @empty
                <p class="text-muted">No comments yet.</p>
                @endforelse
                <div class="text-center mt-3">
                    <a href="{{ route('admin.comments.index') }}" class="small">View All Comments</a>
                </div>
            </div>

            <!-- Tasks Widget (Simplified) -->
            <div class="bg-secondary rounded p-4">
                 <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">To Do List</h6>
                    <button class="btn btn-sm btn-primary rounded-circle" onclick="addTask()"><i class="fa fa-plus"></i></button>
                </div>
                 <div class="d-flex mb-3">
                    <input class="form-control bg-dark border-0 form-control-sm" type="text" id="taskInput" placeholder="Add task...">
                </div>
                <div id="taskList" style="max-height: 200px; overflow-y: auto;">
                    @foreach($tasks as $task)
                    <div class="d-flex align-items-center border-bottom border-dark py-2 task-item" id="task-{{ $task->id }}">
                        <input class="form-check-input m-0" type="checkbox" onchange="toggleTask({{ $task->id }}, this.checked)" {{ $task->completed ? 'checked' : '' }}>
                        <span class="ms-3 {{ $task->completed ? 'text-decoration-line-through text-muted' : '' }} task-title small">{{ $task->title }}</span>
                        <button class="btn btn-link text-danger ms-auto p-0" onclick="deleteTask({{ $task->id }})"><i class="fa fa-times"></i></button>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Stats Chart
    var ctx = document.getElementById('content-chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: 'Articles Count',
                data: {!! json_encode($chartData['data']) !!},
                backgroundColor: 'rgba(235, 22, 22, .5)',
                borderColor: 'rgba(235, 22, 22, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: "#2c2f38" } },
                x: { grid: { color: "#2c2f38" } }
            },
            plugins: { legend: { display: false } }
        }
    });

    // To Do List Logic (Same as before)
    function addTask() {
        const input = document.getElementById('taskInput');
        const title = input.value.trim();
        if (!title) return;
        fetch('{{ route('admin.tasks.store') }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ title: title })
        }).then(res => { if(res.ok) window.location.reload(); });
    }

    function toggleTask(id, completed) {
        fetch(`/admin/tasks/${id}`, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: JSON.stringify({ completed: completed })
        }).then(() => {
            const taskEl = document.querySelector(`#task-${id} .task-title`);
            if (completed) taskEl.classList.add('text-decoration-line-through', 'text-muted');
            else taskEl.classList.remove('text-decoration-line-through', 'text-muted');
        });
    }

    function deleteTask(id) {
        if(!confirm('Delete?')) return;
        fetch(`/admin/tasks/${id}`, {
            method: 'DELETE',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        }).then(res => { if(res.ok) document.getElementById(`task-${id}`).remove(); });
    }
</script>
@endpush
@endsection
