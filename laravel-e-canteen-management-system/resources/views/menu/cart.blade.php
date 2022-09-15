@extends('layouts.student.app_public')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-8">
                  <div class="card">
                        <div class="card-header">
                              Carts
                        </div>

                        <div class="card-body">

                              <table class="dataTable-cart table table-stripped" style="width: 100%;">
                                    <thead>
                                          <tr>
                                                <th>Product</th>
                                                <th>Option</th>
                                                <th>Notes</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                          </tr>
                                    </thead>
                                    <tbody>

                                          @foreach($carts as $cart)
                                          <tr>
                                                <td>
                                                      <img src="{{ $cart->product->media_path ? asset($cart->product->media_path) : asset('storage/defaults/product.png') }}" alt="" style="width: 50px; height: 50px;">
                                                      {{ $cart->product->name }}
                                                </td>
                                                <td>
                                                      @foreach($cart->product_options as $value)
                                                      @foreach($value as $key1 => $value1)
                                                      {{ App\Models\ProductOption::find($key1)->name }}: {{ App\Models\OptionDetail::find($value1)->name }} <br>
                                                      @endforeach
                                                      @endforeach
                                                </td>
                                                <td>{{ $cart->notes }}</td>
                                                <td>{{ $cart->price }}</td>
                                                <td><button type="button" class="btn btn-danger" onclick="promptDeleteCart(this);" data-product-id="{{ $cart->product_id }}" data-time-created="{{ $cart->created_at }}"><i class="fa-solid fa-trash"></i></button></td>
                                          </tr>
                                          @endforeach

                                    </tbody>
                              </table>

                        </div>
                  </div>
            </div>

            <div class="col-4">
                  <div class="card">
                        <div class="card-header">
                              Summary
                        </div>

                        <form action="" method="post">
                              @csrf

                              <div class="card-body">

                                    <div class="list-group">
                                          <div class="list-group-item">
                                                <label class="form-control-label" for="">Rest Time to Pick-Up</label>
                                                <select class="form-control" name="restTime" id="">
                                                      @foreach($restDates as $key => $value)
                                                      <option value="{{ $key }}">{{ $value }}</option>
                                                      @endforeach
                                                </select>
                                          </div>

                                          <div class="list-group-item">
                                                Price
                                                <h4>Total: {{ 10 }}</h4>
                                          </div>
                                    </div>

                              </div>

                              <div class="card-footer">
                                    <button class="btn btn-primary">Procced to Checkout</button>
                              </div>

                        </form>

                  </div>
            </div>
      </div>
</div>

<script>
      function promptDeleteCart(item) {

            SwalWithBootstrap.fire({
                  title: 'Warning',
                  html: 'Delete this product from cart?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Confirm',
                  cancelButtonText: 'Cancel',
                  reverseButtons: true
            }).then((result) => {
                  if (result.isConfirmed) {

                        $.ajaxSetup({
                              headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                        });

                        $.ajax({
                              url: '{{ route("student.menus.cart.delete") }}',
                              method: 'POST',
                              dataType: 'json',
                              data: {
                                    product_id: $(item).data('product-id'),
                                    time_created: $(item).data('time-created'),
                              },
                              success: function(result) {
                                    SwalWithBootstrap.fire({
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