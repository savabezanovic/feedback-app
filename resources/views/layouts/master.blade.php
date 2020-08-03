<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('images/F-Logo.jpg')}}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
{{--        <script src="{{ asset('js/main-js.js') }}"></script>--}}
{{--        <script src="{{ asset('js/superadmin-js.js') }}"></script>--}}
{{--        <script src="{{ asset('js/company-list.js') }}"></script>--}}
{{--        <script src="{{ asset('js/job-titles.js') }}"></script>--}}
{{--        <script src="{{ asset('js/admin-js.js') }}"></script>--}}
{{--        <script src="{{ asset('js/admin-notifications-js.js') }}"></script>--}}
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    </head>
    <body class="app-body">
    <input type="checkbox" id="navbarCheckbox" class="navbar-mobile-checkbox js-nav-mobile-checkbox">
    <nav class="feedback-app-navbar">
        <div class="feedback-app-navbar-title"><img src="images/feedback-app-logo.png" class="feedback-app-logo"
                alt="logo"> FEEDBACK <br /> APP
        </div>
            @yield('users')
        <label for="navbarCheckbox" class="feedback-app-navbar-dropdown-label-close">&#10006;</label>
    </nav>
<div class="feedback-app-main">
    @auth
    @endauth
    <div class="profile-all-forms-container">
        <label for="navbarCheckbox" class="feedback-app-navbar-dropdown-label">
            <img class="feedback-app-navbar-dropdown-icon" src="images/list-icon.png" alt="list icon">
        </label>
        @yield('content')
    </div>
</div>
    @yield('script')
    </body>
</html>
