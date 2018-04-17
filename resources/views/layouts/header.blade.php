

<nav class="navbar navbar-expand-md navbar-light navbar-laravel fixed-top" id="navigation">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class="navbar-img" src="img/logo.png" alt="GoParty.pl">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                <li> <a class="nav-link" href="#" >Start</a> </li>

                <li> <a class="nav-link" href="#">Kluby</a> </li>
                <li> <a class="nav-link" href="#">Wydarzenia</a> </li>
                <li> <a class="nav-link" href="#" >Muzyka</a> </li>
                <li> <a class="nav-link" href="#">O nas</a> </li>

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Logowanie') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ __('Rejestracja') }}</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <!-- Tabs for users -->
                            <a class="dropdown-item" href="{{url('/dashbord')}}">{{ __('Panel użytkownika') }}</a>
                            <!-- End tabs for owner -->

                            <!-- Tabs for owner -->
                            @role('owner')
                            <a class="dropdown-item" href="#">{{ __('Zarządzaj klubem') }}</a>
                            @endrole
                            <!-- End tabs for owner -->

                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <li><a class="nav-link" href="{{ route('clubs.create') }}">{{ __('Dodaj klub') }}</a></li>
            </ul>
        </div>
    </div>
</nav>

