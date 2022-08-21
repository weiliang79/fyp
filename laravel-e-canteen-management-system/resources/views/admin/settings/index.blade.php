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

                              <form method="POST" action="{{ route('admin.settings.save') }}">
                                    @csrf

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Application Name') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text" style="width: 6%;">
                                                            <i class="fa-solid fa-server"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" value="{{ old('app_name', $settings->where('key', 'app_name')->first()->value) }}" placeholder="Application Name">

                                                      @error('app_name')
                                                      <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                      </span>
                                                      @enderror
                                                </div>
                                          </div>
                                    </div>

                                    <div class="row mb-3">
                                          <label for="" class="col-md-3 col-form-label text-md-end">{{ __('Currency Symbol') }}</label>

                                          <div class="col-md-8">
                                                <div class="input-group">
                                                      <div class="input-group-text" style="width: 6%;">
                                                            <i class="fa-solid fa-dollar-sign"></i>
                                                      </div>

                                                      <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" name="currency_symbol" value="{{ old('currency_symbol', $settings->where('key', 'currency_symbol')->first()->value) }}" placeholder="Currency Symbol">

                                                      @error('currency_symbol')
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