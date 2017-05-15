<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {!! Voyager::setting('search_meta_tags') !!}

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ Voyager::setting('title') }}</title>
        {{-- <link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet"> --}}
		<link href="https://fonts.googleapis.com/css?family=Raleway:600|Righteous" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
      
      	{!! Voyager::setting('google_analytics') !!}
    </head>
    <body>
	    <div class="nav">
		    <div class="nav-top">
	            @if (Auth::guest())
	            <ul class="nav-left">
	                <li><a href="/">Home</a></li>
	            </ul>
	            <ul class="nav-right">
	                <li><a href="{{ route('login') }}">Login</a></li>
	                <li><a href="{{ route('register') }}">Register</a></li>
	            </ul>
	            @else
	            <ul class="nav-left">
	                <li><a href="/">Home</a></li>
	            </ul>
	            <ul class="nav-right">
	                <li><p>{{ Auth::user()->name }}</p></li>
	                <li><a href="{{ route('favs') }}">Favourites</a></li>
	                {{-- <li><a href="/dashboard">Account</a></li> --}}
	                <li><a href="{{ route('logout') }}"
	                        onclick="event.preventDefault();
	                                 document.getElementById('logout-form').submit();">
	                        Logout</a>
	                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                        {{ csrf_field() }}
	                    </form></li>
	          	</ul>
	            @endif
            </div>
            <div class="nav-bottom">
				<form class="search" action="/search" method="GET">
					<div class="search-container">
						<div class="search-container-inner">
						  	<label id="search" for="input_search">
								<input id="input_search" name="q" type="text" autocomplete="off" />
							</label>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="main-content">

			@yield('content')

			<footer>
				<p class="footer-text">
					© 2017 by <a href="//www.reedjones.com">Reed Jones</a>. Data aquired from the wonderful <a href="//www.themoviedb.org/">TMDB</a> API.
				</p>
			</footer>
		</div>

		<script src="{{ asset('js/app.js') }}"></script>

		@yield('scripts')
	</body>
</html>