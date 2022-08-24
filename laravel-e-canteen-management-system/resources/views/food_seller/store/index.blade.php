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

                              <form method="POST" action="">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Store Name') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text" style="width: 6%;">
                                                            <i class="fa-solid fa-server"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('store_name') is-invalid @enderror" name="store_name" value="{{ old('store_name', '') }}" placeholder="Application Name">

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
                                                            <i class="fa-solid fa-dollar-sign"></i>
                                                      </div>

            

                                                      @error('store_logo')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
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