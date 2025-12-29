@extends('layouts.admin')

@section('header', 'Database Backup & Restore')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        
        <!-- Backup Section -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Backup Database</h6>
                <div class="d-flex align-items-center mb-4">
                    <i class="fa fa-database fa-3x text-primary me-3"></i>
                    <div>
                        <p class="mb-1 text-muted">Generate a full backup of your database including all tables and data.</p>
                        <p class="mb-0 text-white"><small>Format: .sql file</small></p>
                    </div>
                </div>
                <form action="{{ route('admin.backups.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-3">
                        <i class="fa fa-download me-2"></i> Download Backup
                    </button>
                </form>
            </div>
        </div>

        <!-- Restore Section -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Restore Database</h6>
                <div class="alert alert-warning mb-3">
                    <i class="fa fa-exclamation-triangle me-2"></i> Warning: Restoring will overwrite existing data!
                </div>
                
                <form action="{{ route('admin.backups.restore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="backupData" class="form-label">Upload .sql File</label>
                        <input class="form-control bg-dark" type="file" id="backupData" name="backup_file" required accept=".sql">
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100 py-2" onclick="return confirm('Are you sure you want to restore? Current data will be lost!')">
                        <i class="fa fa-upload me-2"></i> Restore Database
                    </button>
                </form>
            </div>
        </div>

        <!-- Reset Section -->
        <div class="col-sm-12">
            <div class="bg-secondary rounded h-100 p-4 border border-danger">
                <h6 class="mb-4 text-danger">Danger Zone: Reset Website</h6>
                <div class="d-flex align-items-center mb-4">
                    <i class="fa fa-refresh fa-3x text-danger me-3"></i>
                    <div>
                        <p class="mb-1 text-white">Permanently delete all Articles, Categories, Comments, Messages, and Subscribers.</p>
                        <p class="mb-0 text-muted"><small><strong>Users, Pages, and Settings will be PRESERVED.</strong></small></p>
                    </div>
                </div>
                
                <form action="{{ route('admin.backups.reset') }}" method="POST" onsubmit="return confirm('CRITICAL WARNING: This will DELETE all content (Articles, Comments, etc). Are you absolutely sure?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 py-3">
                        <i class="fa fa-trash me-2"></i> Reset Website Data
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
