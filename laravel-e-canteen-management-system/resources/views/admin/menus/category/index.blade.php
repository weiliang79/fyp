@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-10">
                  <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                              Product Category
                              <a href="{{ route('admin.menus.category.create') }}" class="btn btn-primary">New Category</a>
                        </div>

                        <div class="card-body">

                              <table class="dataTable table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th style="width: 20%;">Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>
                                          @foreach($categories as $category)
                                          <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>
                                                      <a class="btn btn-primary" href="{{ route('admin.menus.category.edit', [$category->id]) }}">Edit</a>
                                                      <button type="button" class="btn btn-danger" onclick="promptDeleteWarning(this)" data-id="{{ $category->id }}">Delete</button>
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

<script>
      function promptDeleteWarning(item) {
            Swal.fire({
                  title: 'Warning',
                  html: 'Delete this category?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {
                        console.log($(item).data('id'));

                        $.ajaxSetup({
                              headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                        });

                        $.ajax({
                              url: '{{ route("admin.menus.category.delete") }}',
                              method: 'POST',
                              dataType: 'json',
                              data: {
                                    id: $(item).data('id'),
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