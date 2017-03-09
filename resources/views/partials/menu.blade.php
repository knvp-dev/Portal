<nav class="nav has-shadow">

  <div class="chooseLanguage">
    <a @click="changeLocal('fr')">FR</a>
    <a @click="changeLocal('nl')">NL</a>
  </div>

  <div class="container">
    <div class="nav-left">
      <a class="nav-item is-brand" href="/">
        <img class="is-svg" src="{{ asset('images/KONVERT_LOGO.svg') }}" alt="Konvert logo">
      </a>
    </div>

    <div class="nav-right nav-menu">
      @if(Auth::check())

      @if(!! Auth::user()->isAdmin())
      <a class="nav-item" href="/admin/overzicht" v-text="trans.translate('overzicht')"></a>
      <a class="nav-item" href="/admin/promomateriaal" v-text="trans.translate('promomateriaal')"></a>
      <a class="nav-item" href="/admin/kantoormateriaal" v-text="trans.translate('kantoormateriaal')"></a>
      <a class="nav-item" href="/admin/kantoren" v-text="trans.translate('kantoren')"></a>
      <a class="nav-item" href="/admin/emailhandtekeningen" v-text="trans.translate('emailhandtekeningen')"></a>
      <a class="nav-item" href="/logout" v-text="trans.translate('log uit')"></a>
      @else
      @if(!Auth::user()->isDm())
      <a class="nav-item" href="/overzicht" v-text="trans.translate('overzicht')"></a>
      <a class="nav-item" href="/promomateriaal" v-text="trans.translate('promomateriaal')"></a>
      <a class="nav-item" href="/kantoormateriaal" v-text="trans.translate('kantoormateriaal')"></a>
      <a class="nav-item" href="/beursmateriaal" v-text="trans.translate('beursmateriaal')"></a>
      @endif
      @if(!! Auth::user()->isDm())
        <a class="nav-item" href="/dm/mijn-kantoren" v-text="trans.translate('mijn kantoren')"></a>
      @endif
      <a class="nav-item" href="/emailhandtekeningen" v-text="trans.translate('emailhandtekeningen')"></a>
      <a class="nav-item" href="/logout" v-text="trans.translate('log uit')"></a>
      @endif

      @else
      <span class="nav-item">
        <a class="button is-blue transitioning-icon" href="{{ url('/login') }}">
          <span class="icon is-small has-stacked-icons has-animation">
            <i class="fa fa-lock"></i>
            <i class="fa fa-unlock-alt"></i>
          </span>
          <span v-text="trans.translate('log in')"></span>
        </a>
      </span>
      @endif
    </div>
  </div>
</nav>