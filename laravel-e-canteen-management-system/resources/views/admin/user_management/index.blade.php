@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              User Management
                              <a href="{{ route('admin.user_management.create') }}" class="btn btn-primary">New User</a>
                        </div>

                        <div class="card-body">
                              <table class="dataTable table table-striped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($users as $user)
                                          <tr>
                                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>
                                                      @if($user->role->id == App\Models\Role::ROLE_ADMIN)
                                                      {{ __('Admin') }}
                                                      @elseif($user->role->id == App\Models\Role::ROLE_SELLER)
                                                      {{ __('Food Seller') }}
                                                      @else
                                                      {{ __('Error: Unknown Id') }}
                                                      @endif
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->created_at->format('Y/m/d H:ia') }}</td>
                                                <td>{{ $user->updated_at->format('Y/m/d H:ia') }}</td>
                                                <td><button type="button" class="btn btn-primary" onclick="promptDeleteWarning(this)" data-user-id="{{ $user->id }}">Delete</button></td>
                                          </tr>
                                          @endforeach
                                    </tbody>
                              </table>
                        </div>
                  </div>
            </div>
      </div>
</div>

<script>
      function promptDeleteWarning(item) {
            Swal.fire({
                  title: 'Warning',
                  html: 'Delete this user?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {
                        console.log($(item).data('user-id'));

                        $.ajaxSetup({
                              headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                        });

                        $.ajax({
                              url: '{{ route("admin.user_management.delete") }}',
                              method: 'POST',
                              dataType: 'json',
                              data: {
                                    user_id: $(item).data('user-id'),
                              },
                              success: function(result) {
                                    Swal.fire({
                                          title: 'Success',
                                          html: result,
                                          icon: 'success',
                                    }).then((result) => {
                                          window.location.reload();
                                    });
                              },
                              error: function(error) {
                                    console.log(error);
                              }

                        });
                  } else if (result.dismiss === Swal.DismissReason.cancel) {

                  }
            });
      }
</script>

@endsection