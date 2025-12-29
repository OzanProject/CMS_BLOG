<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="userModalLabel">{{ __('common.add') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div id="methodField"></div>
                
                <div class="modal-body">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('common.name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="{{ __('common.name') }}">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('users.email') ?? 'Email' }} <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Email">
                    </div>

                    <!-- Role -->
                    <div class="mb-3">
                        <label for="role" class="form-label">{{ __('users.role') }} <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role">
                            <option value="2">{{ __('users.writer') }}</option>
                            <option value="1">{{ __('users.admin') }}</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('users.password') ?? 'Password' }}</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Min. 8 characters">
                        <div id="passwordHelp" class="form-text d-none">Leave empty to keep current password.</div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('users.confirm_password') ?? 'Confirm Password' }}</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password">
                    </div>
                </div>
                
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">{{ __('common.close') }}</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">{{ __('common.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
