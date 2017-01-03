@extends('layouts.app')

@section('content')
<section class="section has-text-centered">
    <div class="container">
        <div class="heading">
            <h1 class="title">Log in</h1>
            <h2 class="subtitle">
              {{-- Gebruik het emailadres van het kantoor om in te loggen. --}}
          </h2>
          
          <i class="fa fa-lock p-20"></i>
      </div>
      <div class="centered-form">
          <form role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}
            <p class="control">
                <label for="email" class="label">E-Mail Address</label>
                <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                <span class="help is-danger">{{ $errors->first('email') }}</span>
                @endif
            </p>

            <p class="control">
                <label for="password" class="label">Password</label>
                <input id="password" type="password" class="input" name="password" required>

                @if ($errors->has('password'))
                <span class="help is-danger">{{ $errors->first('password') }}</span>
                @endif
            </p>

            <p class="control">
                <button type="submit" class="button is-primary">
                    Login
                </button>

                <a class="button is-link" href="{{ url('/password/reset') }}">
                    Forgot Your Password?
                </a>
            </p>
        </form>
    </div>
</div>
</section>
@endsection
