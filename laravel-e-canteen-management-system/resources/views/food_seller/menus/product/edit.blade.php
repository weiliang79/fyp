@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              Product
                        </div>

                        <div class="card-body">

                              <form action="{{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'food_seller.menus.product.create') ? route('food_seller.menus.product.save') : route('food_seller.menus.product.update') }}" method="post">
                                    @csrf
                                    @include('food_seller.menus.product._form', ['product' => $product, 'categories' => $categories])

                                    <div class="row mb-0">
                                          <div class="col-md-8 offset-md-3">
                                                <button type="submit" class="btn btn-primary">
                                                      {{ __('Submit') }}
                                                </button>
                                          </div>
                                    </div>
                                    
                              </form>

                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection