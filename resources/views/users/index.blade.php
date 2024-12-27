@extends('layouts.dashboard')

@section('title')
    Users
@endsection

@section('content')
    <div class="page-inner">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div class="page-header mb-0">
                <h3 class="fw-bold">Users</h3>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}">Users</a>
                    </li>
                </ul>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-round">Add User</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->getRoleNames()->first() }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>

                                                <!-- Delete Button -->
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-name="{{ $user->name }}" data-id="{{ $user->id }}">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#basic-datatables").DataTable({});

        // Delete User
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const userName = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `User '${userName}' will be deleted from this app. You won't be able to revert this!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a hidden form to submit the delete request
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = `{{ url('users') }}/${userId}`;
                            form.style.display = 'none';

                            // Add CSRF and DELETE method inputs
                            const csrfInput = document.createElement('input');
                            csrfInput.name = '_token';
                            csrfInput.value = '{{ csrf_token() }}';
                            csrfInput.type = 'hidden';
                            form.appendChild(csrfInput);

                            const methodInput = document.createElement('input');
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            methodInput.type = 'hidden';
                            form.appendChild(methodInput);

                            // Append the form to the body and submit it
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
