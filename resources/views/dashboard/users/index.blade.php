@extends('dashboard.main')
@section('title', 'Users - Consent Uganda')
@section('content')
    <div class="dash-page-header">
        <div>
            <h1>Users management</h1>
            <p>Create accounts and update login credentials for other users.</p>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class='bx bx-plus'></i> Create new user
        </button>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show dash-alert" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show dash-alert" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show dash-alert" role="alert">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover dash-table mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ str_replace('_', ' ', ucfirst($user->role)) }}</td>
                                <td>
                                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @php
                                        $canManage = ! $user->isSuperAdmin() || auth()->user()->isSuperAdmin();
                                    @endphp

                                    @if ($canManage && $user->id !== auth()->id())
                                        <div class="btn-group" role="group">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUserModal{{ $user->id }}"
                                            >
                                                <i class='bx bx-edit-alt'></i> Edit
                                            </button>

                                            <form
                                                action="{{ route('users.destroy', $user) }}"
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this user?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif ($user->id === auth()->id())
                                        <span class="text-muted small">Use Settings for your password</span>
                                    @else
                                        <span class="text-muted small">Protected</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">No users found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    {{-- Create User Modal --}}
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create new user</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                    id="role" name="role" required>
                                <option value="user">User</option>
                                <option value="editor">Editor</option>
                                <option value="admin">Admin</option>
                                @if (auth()->user()->isSuperAdmin())
                                    <option value="super_admin">Super admin</option>
                                @endif
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">Active account</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create user</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit User Modals (other users only) --}}
    @foreach ($users as $user)
        @php
            $canManage = (! $user->isSuperAdmin() || auth()->user()->isSuperAdmin())
                && $user->id !== auth()->id();
        @endphp

        @if ($canManage)
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit user credentials</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="edit_name_{{ $user->id }}" class="form-label">Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="edit_name_{{ $user->id }}"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="edit_email_{{ $user->id }}" class="form-label">Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="edit_email_{{ $user->id }}"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="edit_password_{{ $user->id }}" class="form-label">Password</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="edit_password_{{ $user->id }}"
                                        name="password"
                                        placeholder="Leave blank to keep current password"
                                        autocomplete="new-password"
                                    >
                                    <div class="form-text">Leave blank if you do not want to change the password.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_password_confirmation_{{ $user->id }}" class="form-label">Confirm password</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="edit_password_confirmation_{{ $user->id }}"
                                        name="password_confirmation"
                                        placeholder="Confirm new password"
                                        autocomplete="new-password"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="edit_role_{{ $user->id }}" class="form-label">Role</label>
                                    <select
                                        class="form-select"
                                        id="edit_role_{{ $user->id }}"
                                        name="role"
                                        required
                                    >
                                        <option value="user" @selected(old('role', $user->role) === 'user')>User</option>
                                        <option value="editor" @selected(old('role', $user->role) === 'editor')>Editor</option>
                                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                                        @if (auth()->user()->isSuperAdmin())
                                            <option value="super_admin" @selected(old('role', $user->role) === 'super_admin')>Super admin</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="1"
                                        id="edit_is_active_{{ $user->id }}"
                                        name="is_active"
                                        @checked(old('is_active', $user->is_active))
                                    >
                                    <label class="form-check-label" for="edit_is_active_{{ $user->id }}">Active account</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
