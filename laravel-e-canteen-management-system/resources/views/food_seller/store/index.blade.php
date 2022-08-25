@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-10">
                  <div class="card">
                        <div class="card-header">
                              Settings
                        </div>

                        <div class="card-body">

                              <form method="POST" action="{{ route('food_seller.store.save') }}">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Store Name') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text" style="width: 6%;">
                                                            <i class="fa-solid fa-server"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name" value="{{ old('store_name', '') }}" placeholder="Store Name">

                                                      @error('store_name')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Store Logo') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text" style="width: 6%;">
                                                            <i class="fa-solid fa-tag"></i>
                                                      </div>

                                                      <input id="logo_path" class="form-control" type="text" name="logo_path">

                                                      <a class="btn btn-primary" id="lfm" data-input="logo_path" data-preview="holder">Choose Image</a>

                                                      @error('logo_path')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    {{-- image preview --}}
                                    <div class="row mb-3 justify-content-center">
                                          <div class="col-1 " id="holder">

                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Description') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text" style="width: 6%;">
                                                            <i class="fa-solid fa-server"></i>
                                                      </div>

                                                      <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>

                                                      @error('store_name')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

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