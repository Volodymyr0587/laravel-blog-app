<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Home - Awesome Blog</title>
        <!-- Css -->
        {{--
        <link rel="stylesheet" href="style.css" /> --}}
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <!-- Font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    </head>

    <body>
        <div id="wrapper">
            <!-- header -->
            @yield('header')
            <!-- sidebar -->
            <div class="sidebar">
                <span class="closeButton">&times;</span>
                <p class="brand-title"><a href="{{ route('welcome.index') }}">Awesome Blog</a></p>
                <div class="side-links">
                    <ul>
                        <li><a class="{{ request()->routeIs('welcome.index') ? 'active' : '' }}" href="{{ route('welcome.index') }}">Home</a></li>
                        <li><a class="{{ request()->routeIs('blog.index') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a></li>
                        <li><a class="{{ request()->routeIs('blog.about') ? 'active' : '' }}" href="{{ route('blog.about') }}">About</a></li>
                        <li><a class="{{ request()->routeIs('blog.contact.index') ? 'active' : '' }}" href="{{ route('blog.contact.index') }}">Contact</a></li>
                        @guest
                        <li><a class="{{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a></li>
                        <li><a class="{{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a></li>
                        @endguest
                        @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li><a onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="{{ request()->routeIs('logout') ? 'active' : '' }}"
                                    href="{{ route('logout') }}">
                                    Log out
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
                <!-- sidebar footer -->
                <footer class="sidebar-footer">
                    <div>
                        <a href=""><i class="fab fa-facebook-f"></i></a>
                        <a href=""><i class="fab fa-instagram"></i></a>
                        <a href=""><i class="fab fa-twitter"></i></a>
                    </div>
                    <small>&copy 2021 Awesome Blog</small>
                </footer>
            </div>
            <!-- Menu Button -->
            <div class="menuButton">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <!-- main -->
            @yield('main')
            <!-- Main footer -->
            <footer class="main-footer">
                <div>
                    <a href=""><i class="fab fa-facebook-f"></i></a>
                    <a href=""><i class="fab fa-instagram"></i></a>
                    <a href=""><i class="fab fa-twitter"></i></a>
                </div>
                <small>&copy {{ date('Y') }} Awesome Blog</small>
            </footer>
        </div>
        <!-- Click events to menu and close buttons using javaascript-->
        <script>
            document
            .querySelector(".menuButton")
            .addEventListener("click", function() {
                document.querySelector(".sidebar").style.width = "100%";
                document.querySelector(".sidebar").style.zIndex = "5";
            });
        document
            .querySelector(".closeButton")
            .addEventListener("click", function() {
                document.querySelector(".sidebar").style.width = "0";
            });
        </script>
    </body>

</html>
