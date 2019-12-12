@extends('auth.layouts.app')

@push('css')
    @toastr_css
@endpush

@section('content')
<section id="wrapper">
    <div class="login-register" style="background-image:url({{ asset('img/login-register.jpg') }});">
        <div class="login-box card">
        <div class="card-body">
            <form class="form-horizontal form-material" method="POST" action="{{ route('password.update') }}">
                @csrf
                <h3 class="box-title m-b-20">Reset Password</h3>
                <input type="hidden" name="token" value="{{ $token }}">
                <input id="email" type="hidden" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="password-confirm" placeholder="{{ __('Confirm Password') }}" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</section>
@endsection

@push('js')
    @toastr_js
    @toastr_render
    <script>
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error('{{ $error }}','Error',{
                    closeButton:true,
                    progressBar:true,
                });
            @endforeach
        @endif
    </script>
@endpush
