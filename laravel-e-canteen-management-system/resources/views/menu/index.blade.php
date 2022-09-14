@extends('layouts.student.app_public')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-3">
                  <div class="card">
                        <div class="card-header">
                              Filter
                        </div>

                        <div class="card-body">

                              <form action="#" method="get">

                                    <div class="mb-3">
                                          <h6>Store</h6>

                                          <ul class="list-group">
                                                @foreach($allStores as $store)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                      <div>
                                                            <input class="form-check-input me-1" type="checkbox" name="stores[]" value="{{ $store->id }}" {{ Request::get('stores') ? (in_array($store->id, Request::get('stores')) ? 'checked' : '') : '' }}>
                                                            {{ $store->name }}
                                                      </div>
                                                      <span class="badge bg-primary rounded-pill">{{ $store->products()->count() }}</span>
                                                </li>
                                                @endforeach
                                          </ul>
                                    </div>

                                    <div class="mb-3">
                                          <h6>Category</h6>

                                          <ul class="list-group">
                                                @foreach($allCategories as $category)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                      <div>
                                                            <input class="form-check-input me-1" type="checkbox" name="categories[]" value="{{ $category->id }}" {{ Request::get('categories') ? (in_array($category->id, Request::get('categories')) ? 'checked' : '') : '' }}>
                                                            {{ $category->name }}
                                                      </div>
                                                      <span class="badge bg-primary rounded-pill">{{ $category->products()->count() }}</span>
                                                </li>
                                                @endforeach
                                          </ul>
                                    </div>

                                    <button class="btn btn-primary" type="submit">Apply Filter</button>

                              </form>

                        </div>
                  </div>
            </div>

            <div class="col-9">
                  <div class="card">
                        <div class="card-header">
                              Menu
                        </div>

                        <div class="card-body">

                              @foreach($allStores as $store)
                              <div class="container-fluid mb-3">
                                    <h5>{{ $store->name }}</h5>
                                    @if($products->contains('store_id', $store->id))
                                    <div class="row row-cols-auto">

                                          @foreach($products->where('store_id', $store->id) as $product)
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="{{ $product->media_path ? asset($product->media_path) : asset('storage/defaults/product.png') }}" alt="{{ $product->name }}" title="{{ $product->description }}">
                                                      </div>
                                                      <div class="card-body d-flex flex-column justify-content-between">
                                                            <h5 class="card-title">{{ $product->name }}</h5>
                                                            <button type="button" class="btn btn-primary" onclick="foodButtonClicked(this);" data-id="{{ $product->id }}">Show Details</button>
                                                      </div>
                                                </div>
                                          </div>
                                          @endforeach
                                    </div>
                                    @else
                                    <div class="row justify-content-center">
                                          <div class="col-auto">
                                                <p>No Product found.</p>
                                          </div>
                                    </div>
                                    @endif

                              </div>
                              @endforeach

                              <div class="container-fluid">
                                    <h5>Store</h5>
                                    <div class="row row-cols-auto">
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="http://localhost:8000/storage/photos/3/hamburger.jpg" alt="">
                                                      </div>
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 1</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="http://localhost:8000/storage/photos/3/hamburger.jpg" alt="">
                                                      </div>
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 2</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="http://localhost:8000/storage/photos/3/hamburger.jpg" alt="">
                                                      </div>
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 3</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="http://localhost:8000/storage/photos/3/hamburger.jpg" alt="">
                                                      </div>
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 4</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="http://localhost:8000/storage/photos/3/hamburger.jpg" alt="">
                                                      </div>
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 5</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="http://localhost:8000/storage/photos/3/hamburger.jpg" alt="">
                                                      </div>
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 6</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <div class="menu-card-img-border">
                                                            <img class="card-img-top menu-card-img" src="http://localhost:8000/storage/photos/3/hamburger.jpg" alt="">
                                                      </div>
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 7</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
      </div>
</div>

<template id="options_templates">
      <div class="container">
            <div class="row row-cols-auto">
                  <h5 class="col">option_name</h5>
            </div>
            <div class="row row-cols-auto mb-2">

                  option_field

            </div>
      </div>
</template>

<template id="details_templates">
      <div class="col form-check form-check-inline">
            <input class="form-check-input" type="radio" id="id" name="name" value="value" checked>
            <label class="form-check-label" for="">detail_name</label>
      </div>
</template>

<template id="note_template">
      <div class="container">
            <div class="row row-cols-auto">
                  <h5 class="col">Note</h5>
                  <textarea class="form-control col" name="note" id="note" cols="10" rows="2"></textarea>
            </div>
      </div>
</template>

<script>
      function foodButtonClicked(item) {
            SwalWithBootstrap.fire({
                  title: 'Loading',
            });
            SwalWithBootstrap.showLoading();

            $.ajaxSetup({
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  },
            });

            $.ajax({
                  url: '{{ route("student.menus.get_food_options") }}',
                  method: 'POST',
                  dataType: 'json',
                  data: {
                        id: $(item).data('id'),
                  },
                  success: function(result) {
                        console.log(result);

                        var htmlResult = '';
                        var html = $('#options_templates').html();
                        for (i = 0; i < result.options.length; i++) {
                              htmlResult = htmlResult + html.replace('option_name', result.options[i].name);
                              var temp = '';
                              for (j = 0; j < result.details.length; j++) {
                                    if (result.details[j].product_option_id == result.options[i].id) {
                                          var detailHtml = $('#details_templates').html();
                                          detailHtml = detailHtml.replace('id="id"', 'id="option' + result.options[i].id + '"');
                                          detailHtml = detailHtml.replace('name="name"', 'name="' + result.options[i].id + '"');
                                          detailHtml = detailHtml.replace('value="value"', 'value="' + result.details[j].id + '"');
                                          detailHtml = detailHtml.replace('detail_name', result.details[j].name);

                                          if (result.details[j].name !== 'None') {
                                                detailHtml = detailHtml.replace('checked', '');
                                          }

                                          temp = temp + detailHtml;
                                    }
                              }
                              htmlResult = htmlResult.replace('option_field', temp);
                        }

                        var noteHtml = $('#note_template').html();

                        SwalWithBootstrap.fire({
                              title: result.product.name,
                              imageWidth: 300,
                              imageHeight: 200,
                              imageUrl: result.product.media_path === null ? '{{ asset("storage/defaults/product.png") }}' : '{{ Request::root() }}/' + result.product.media_path,
                              html: '<p>' + result.product.description + '</p>' + htmlResult + noteHtml,
                              showCancelButton: true,
                              reverseButtons: true,
                              confirmButtonText: 'Add to cart',
                              cancelButtonText: 'Cancel',
                              preConfirm: () => {
                                    var note = SwalWithBootstrap.getPopup().querySelector('#note').value;
                                    var data = {
                                          product_id: result.product.id,
                                          note: note,
                                          options: [],
                                    };

                                    for (i = 0; i < result.options.length; i++) {
                                          input = SwalWithBootstrap.getPopup().querySelector('#option' + result.options[i].id).value;
                                          data.options.push({
                                                [result.options[i].id]: input,
                                          });
                                    }
                                    return data;
                              },
                        }).then((swalResult) => {
                              console.log(swalResult.value);

                              $.ajax({
                                    url: '{{ route("student.menus.add_cart") }}',
                                    method: 'POST',
                                    dataType: 'json',
                                    data: swalResult.value,
                                    success: function (successResult) {
                                          console.log(successResult);

                                          SwalWithBootstrap.fire({
                                                title: 'Success',
                                                html: successResult,
                                                icon: 'success',
                                          }).then(() => {
                                                window.location.reload();
                                          });
                                    }, 
                                    error: function (error) {
                                          console.log(error);
                                    }
                              });
                        });
                  },
                  error: function(error) {
                        console.log(error);
                  }
            });

            setTimeout(
                  function() {

                  },
                  1000
            );
      }
</script>

@endsection