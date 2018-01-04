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
<section class="section has-text-centered h100 login-section">
    <div class="container login-panel">
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
</body>
</html>
