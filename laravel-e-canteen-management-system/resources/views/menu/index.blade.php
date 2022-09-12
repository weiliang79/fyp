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
                                    @csrf

                                    <div class="mb-3">
                                          <h6>Store</h6>

                                          <ul class="list-group">
                                                @foreach($stores as $store)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                      <div>
                                                            <input class="form-check-input me-1" type="checkbox" name="stores[]" value="{{ $store->id }}">
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
                                                @foreach($categories as $category)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                      <div>
                                                            <input class="form-check-input me-1" type="checkbox" name="categories[]" value="{{ $category->id }}">
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

                              @foreach($stores as $store)
                              <div class="container-fluid mb-3">
                                    <h5>{{ $store->name }}</h5>
                                    <div class="row row-cols-auto">
                                          @foreach($store->products as $product)
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem; height: 17rem;">
                                                      <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Hamburger_%28black_bg%29.jpg" alt="">
                                                      <div class="card-body d-flex flex-column justify-content-between">
                                                            <h5 class="card-title">{{ $product->name }}</h5>
                                                            <button type="button" class="btn btn-primary" onclick="foodButtonClicked(this);">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          @endforeach
                                    </div>
                              </div>
                              @endforeach

                              <div class="container-fluid">
                                    <h5>Store</h5>
                                    <div class="row row-cols-auto">
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem;">
                                                      <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Hamburger_%28black_bg%29.jpg" alt="">
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 1</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem;">
                                                      <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Hamburger_%28black_bg%29.jpg" alt="">
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 2</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem;">
                                                      <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Hamburger_%28black_bg%29.jpg" alt="">
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 3</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem;">
                                                      <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Hamburger_%28black_bg%29.jpg" alt="">
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 4</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem;">
                                                      <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Hamburger_%28black_bg%29.jpg" alt="">
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 5</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem;">
                                                      <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Hamburger_%28black_bg%29.jpg" alt="">
                                                      <div class="card-body">
                                                            <h5 class="card-title">Card title 6</h5>
                                                            <p class="card-text">This is test</p>
                                                            <button type="button" class="btn btn-primary">Test</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <div class="col my-2">
                                                <div class="card" style="width: 10rem;">
                                                      <img class="card-img-top" src="https://upload.wikimedia.org/wikipedia/commons/4/47/Hamburger_%28black_bg%29.jpg" alt="">
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

<script>
      function foodButtonClicked(item) {
            Swal.fire({
                  title: 'Loading',
            });
            Swal.showLoading();

            setTimeout(
                  function() {
                        Swal.fire({
                              title: 'Food Options',
                        });
                  },
                  1000
            );
      }
</script>

@endsection