<nav class="nav has-shadow">
  <div class="container">
    <div class="nav-left">
      <a class="nav-item is-brand" href="/">
        <img class="is-svg" src="{{ asset('images/KONVERT_LOGO.svg') }}" alt="Konvert logo">
      </a>
    </div>

    <span class="nav-toggle">
      <span></span>
      <span></span>
      <span></span>
    </span>

    <div class="nav-right nav-menu">
      @if(Auth::check())
        <a class="nav-item" href="/promomateriaal">
          Promomateriaal
        </a>
        <a class="nav-item" href="/kantoormateriaal">
          Kantoormateriaal
        </a>
        <a class="nav-item" href="/beursmateriaal">
          Beursmateriaal
        </a>
        <a class="nav-item" href="/documenten">
          Documenten
        </a>
        <a class="nav-item" href="logos">
          Logo's
        </a>
        <a class="nav-item" href="#">
          Log uit
        </a>
      @else
        <span class="nav-item">
          <a class="button is-primary" href="{{ url('/login') }}">
            <span class="icon">
              <i class="fa fa-lock"></i>
            </span>
            <span>Login</span>
          </a>
        </span>
      @endif
    </div>
  </div>
</nav>