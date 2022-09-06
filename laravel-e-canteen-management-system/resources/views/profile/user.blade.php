@extends('layouts.app')

@section('content')

<div class="container py-4">
      <div class="row justify-content-center">
            <div class="col-md-20">
                  <div class="card">
                        <div class="card-header">
                              Profile
                        </div>

                        <div class="card-body">
                              <div class="row">
                                    <div class="col">

                                          <div class="card mb-4">
                                                <div class="card-header">
                                                      Edit Profile
                                                </div>

                                                <div class="card-body">

                                                      <form method="POST" action="{{ route('admin.profile.update_name') }}">
                                                            @csrf

                                                            <div class="row mb-3">
                                                                  <label for="" class="col-md-3 col-form-label text-md-end">{{ __('First and Last Name') }}</label>

                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 8%;">
                                                                                    <i class="fa-solid fa-id-card fa-fw"></i>
                                                                              </div>

                                                                              <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" placeholder="First Name">
                                                                              <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" placeholder="Last Name">

                                                                              @error('first_name')
                                                                              <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                              </span>
                                                                              @enderror

                                                                              @error('last_name')
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

                                          <div class="card mb-4">
                                                <div class="card-header">
                                                      Update Email Address
                                                </div>

                                                <div class="card-body">

                                                </div>
                                          </div>

                                          <div class="card">
                                                <div class="card-header">
                                                      Change Password
                                                </div>

                                                <div class="card-body">

                                                      <form method="POST" action="{{ route('admin.profile.update_password') }}">
                                                            @csrf

                                                            <div class="row mb-3">
                                                                  <label for="" class="col-md-3 col-form-label text-md-end">New Password</label>

                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 8%;">
                                                                                    <i class="fa-solid fa-key fa-fw"></i>
                                                                              </div>

                                                                              <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New Password">

                                                                              @error('password')
                                                                              <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                              </span>
                                                                              @enderror
                                                                        </div>
                                                                  </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                  <label for="" class="col-md-3 col-form-label text-md-end">Confirm Password</label>

                                                                  <div class="col-md-8">
                                                                        <div class="input-group">
                                                                              <div class="input-group-text justify-content-center" style="width: 8%;">
                                                                                    <i class="fa-solid fa-key fa-fw"></i>
                                                                              </div>

                                                                              <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" placeholder="Confirm Password">

                                                                              @error('confirm_password')
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

                                    <div class="col-4">

                                          <ul class="list-group">
                                                <li class="list-group-item">
                                                      <h5 class="mb-0">Full Name</h5>
                                                      <p class="mb-0">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                                </li>
                                                <li class="list-group-item">
                                                      <h5 class="mb-0">Username</h5>
                                                      <p class="mb-0">{{ auth()->user()->username }}</p>
                                                </li>
                                                <li class="list-group-item">
                                                      <h5 class="mb-0">Role</h5>
                                                      <p class="mb-0">{{ auth()->user()->role->name }}</p>
                                                </li>
                                                <li class="list-group-item">
                                                      <h5 class="mb-0">Email Address</h5>
                                                      <p class="mb-0">{{ auth()->user()->email ? auth()->user()->email : 'None' }}</p>
                                                </li>
                                          </ul>

                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>

@endsection