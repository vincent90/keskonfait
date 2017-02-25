<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
        <link href="/css/bootstrap-datepicker/bootstrap-datepicker3.standalone.css" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = <?php
echo json_encode([
    'csrfToken' => csrf_token(),
]);
?>
        </script>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (!Auth::guest())
                            @if (Auth::user()->superuser)
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User management <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/users') }}">View all users</a></li>
                                    <li><a href="{{ url('/users/create') }}">Create a new user</a></li>
                                </ul>
                            </li>
                            @endif
                            <li><a href="{{ url('/tasks') }}">My Tasks</a></li>
                            <li><a href="{{ url('/projects') }}">My projects</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    @if (Auth::user()->user_image)
                                    <img src="{{URL::asset('images/' . Auth::user()->user_image)}}" alt="User image">
                                    @endif
                                    {{ Auth::user()->fullName() }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/users/' . Auth::id()) }}">My profile</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/users/' . Auth::id() . '/edit_password') }}">Edit my password</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-body">
                        <p><b id="item-to-delete"></b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="/js/app.js"></script>
        <script src="/js/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script>
                                               $(document).ready(function () {
                                                   $('.datepicker').datepicker({autoclose: true});

                                                   // Bootstrap modal invoker
                                                   var $invoker = null;

                                                   $('#confirm-delete').on('show.bs.modal', function (e) {
                                                       $invoker = $(e.relatedTarget);
                                                       $('#item-to-delete').text($invoker.data("item-to-delete"))
                                                   });

                                                   $('#confirm-delete').on('click', '.btn-ok', function (e) {
                                                       let $form = $invoker.parent();
                                                       $form.submit();
                                                       return false;
                                                   });
                                               });
        </script>
    </body>
</html>
