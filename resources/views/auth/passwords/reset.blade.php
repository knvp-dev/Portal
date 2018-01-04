<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Konvert Marketing') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="/css/vendor.css">
    <link href="/css/app.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                            'csrfToken' => csrf_token(),
                        ]); ?>
        </script>
    </head>
    <body>

<section class="section has-text-centered h100 login-section" style="z-index:999;">
    <div class="container login-panel">
        <div class="heading">
            <h1 class="title">Reset Password</h1>
            <h2 class="subtitle">
              {{-- Gebruik het emailadres van het kantoor om in te loggen. --}}
          </h2>
          
            @if(session('status'))
            <p>{{ session('status') }}</p>
            @endif

          <i class="fa fa-lock p-20"></i>
      </div>
      <div class="centered-form">
          <form role="form" method="POST" action="{{ url('/password/reset') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <p class="control">
                <label for="email" class="label">E-Mail Address</label>
                <input id="email" type="email" class="input" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                <span class="help is-danger">{{ $errors->first('email') }}</span>
                @endif
            </p>

            <p class="control">
                <label for="password" class="label">New Password</label>
                <input id="password" type="password" class="input" name="password" required>

                @if ($errors->has('password'))
                <span class="help is-danger">{{ $errors->first('password') }}</span>
                @endif
            </p>

            <p class="control">
                <label for="password" class="label">Confirm Password</label>
                <input id="password-confirm" type="password" class="input" name="password_confirmation" required>

                @if ($errors->has('password_confirmation'))
                <span class="help is-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </p>

            <p class="control">
                <button type="submit" class="button is-primary">
                    Reset Password
                </button>
                <a class="button is-link" href="{{ url('/login') }}">
                    Login
                </a>
            </p>

        </form>
    </div>
</div>
</section>
        </body>
        </html>