<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
      .feather {
        width: 16px;
        height: 16px;
        vertical-align: text-bottom;
      }

      /*
       * Sidebar
       */

      .sidebar {
        /*position: fixed;*/
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100; /* Behind the navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
      }

      .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
      }

      @supports ((position: -webkit-sticky) or (position: sticky)) {
        .sidebar-sticky {
          position: -webkit-sticky;
          position: sticky;
        }
      }

      .sidebar .nav-link {
        font-weight: 500;
        color: #333;
      }

      .sidebar .nav-link .feather {
        margin-right: 4px;
        color: #999;
      }

      .sidebar .nav-link.active {
        color: #007bff;
      }

      .sidebar .nav-link:hover .feather,
      .sidebar .nav-link.active .feather {
        color: inherit;
      }

      .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
      }


       .form-control {
        padding: .75rem 1rem;

        border-radius: 0;
      }

      .form-control-dark {
        color: #fff;
        background-color: rgba(255, 255, 255, .1);
        border-color: rgba(255, 255, 255, .1);
      }

      .form-control-dark:focus {
        border-color: transparent;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
      }
    </style>
    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
          <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Left Side Of Navbar -->
              <ul class="navbar-nav mr-auto">

              </ul>

              <!-- Right Side Of Navbar -->
              <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
                  @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                  @endif
                @else
                  <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ route('logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>
                      <a class="dropdown-item" href="/users/change_password">
                        Change Password
                      </a>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                    </div>
                  </li>
                @endguest
              </ul>
            </div>
          </div>
        </nav>

    <main class="pt-1">
      <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block bg-white sidebar shadow">
            <div class="sidebar-sticky">
              <ul class="nav flex-column" id="nav">
                @can('isAdmin')
                <li class="nav-item">
                  <a class="nav-link" href="/home">
                    <span data-feather="home"></span>
                    Dashboard <span class="sr-only">(current)</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/staffs">
                    <span data-feather="users"></span>
                    Staffs
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/requests">
                    <span data-feather="bell"></span>
                    Requests
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/leaves">
                    <span data-feather="layers"></span>
                    leaves
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/holidays">
                    <span data-feather="bar-chart-2"></span>
                    Holidays
                  </a>
                </li>
                <!--<li class="nav-item">
                  <a class="nav-link" href="#">
                    <span data-feather="dollar-sign"></span>
                    Salary
                  </a>
                </li>-->
                @endcan

                @can('isEmployee')
                <li class="nav-item">
                  <a class="nav-link" href="/employee/home">
                    <span data-feather="home"></span>
                    Dashboard <span class="sr-only">(current)</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/employee/requests">
                    <span data-feather="bell"></span>
                    Leave Requests
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/holidays">
                    <span data-feather="bar-chart-2"></span>
                    Holidays
                  </a>
                </li>
                <!--<li class="nav-item">
                  <a class="nav-link" href="#">
                    <span data-feather="dollar-sign"></span>
                    Salary Report
                  </a>
                </li>-->
                @endcan
              </ul>

            </div>
          </nav>

          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

            @yield('content')

          </main>
        </div>
      </div>
    </main>
    
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
      <script type="text/javascript">
        (function () {
          'use strict'
          feather.replace()
        }())
      </script>

      <script type="text/javascript">
        $(function(){
            var current = location.pathname;
            $('#nav li a').each(function(){
                var $this = $(this);
                // if the current path is like this link, make it active
                if(($this.attr('href').indexOf(current) !== -1) || (current.includes($this.attr('href')))){
                    $this.addClass('active');
                }
            })
        })
      </script>
</body>
</html>
</body>
</html>
