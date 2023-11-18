@extends('layouts.app')

@section('content')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script type="text/javascript" charset="utf8" src="{{asset('pluto/js/addJs/jquery-3.6.0.min.js')}}"></script>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('initial') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="initial-btn" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <script>
                        $('#initial-btn').on('click', function (e) { 
                           
                            
                            'id': $('#hidden_id').val(),
                            'name': $('#name').val(),
                            'username': $('#username').val(),
                            'password': $('#password').val(),
                        })
                        $.ajaxSetup({
                            headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                          });
                          $.ajax({
                              type: 'post',
                              url: 'initial',
                              data: initialform,
                              dataType: 'json',
                              success: function(response) {
                                Swal.fire({
                                  position: 'center',
                                  icon: 'success',
                                  title: 'Successfully Registered',
                                  showConfirmButton: false,
                                  timer: 1500
                                });
                                
                              
                              }
                            })
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
