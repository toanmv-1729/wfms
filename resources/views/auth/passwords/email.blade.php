@extends('auth.layouts.app')

@section('content')
<section id="wrapper">
    <div class="login-register" style="background-image:url({{ asset('img/login-register.jpg') }});">
        <div class="login-box card">
        <div class="card-body">
            <form class="form-horizontal" id="" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group ">
                    <div class="col-xs-12">
                        <div >
                            <a href="{{ route('login') }}" id="to-login">
                                <i class="fa fa-long-arrow-left"></i>
                            </a>
                            <h3>Recover Password</h3>
                        </div>
                        <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control @error('email') is-invalid @enderror" type="text" required="" name="email" placeholder="Email" value="{{ old('email') }}"></div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</section>
@endsection
