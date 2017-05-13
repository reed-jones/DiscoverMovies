<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ Voyager::setting('title') }}</title>
        {{-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> --}}
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
      
      	
      	{{ Voyager::setting('google_analytics') }}
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
								<input id="input_search" name="search" type="text" autocomplete="off" />
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

		<script>
			document.getElementById('input_search').onfocus = function () {
				document.getElementById('search').classList.add('activeSearch');
			};

			document.getElementById('input_search').onblur = function () {
					document.getElementById('search').classList.remove('activeSearch');
			};
		</script>

    	@include('scripts.jQuery')

		<script>
	/*
		By Osvaldas Valutis, www.osvaldas.info
		Modified by Reed Jones, www.reedjones.com
		Available for use under the MIT License
	*/

	
		;( function( $, window, document, undefined )
	{
		'use strict';

		var $element		= $('.nav'),
			elClassHidden	= 'gone',
			throttleTimeout	= 500;
			

		if( !$element.length ) return true;

		var $window			= $('.main-content'),
			wHeight			= $window.height(),
			wScrollCurrent	= 0,
			wScrollBefore	= 0,
			wScrollDiff		= 0,

			throttle = function( delay, fn )
			{
				var last, deferTimer;
				return function()
				{
					var context = this, args = arguments, now = +new Date;
					if( last && now < last + delay )
					{
						clearTimeout( deferTimer );
						deferTimer = setTimeout( function(){ last = now; fn.apply( context, args ); }, delay );
					}
					else
					{
						last = now;
						fn.apply( context, args );
					}
				};
			};

		$window.on( 'scroll', throttle( throttleTimeout, function()
		{
			wScrollCurrent	= $window.scrollTop();
			wScrollDiff		= wScrollBefore - wScrollCurrent;

			if( wScrollCurrent <= 0 ) {// scrolled to the very top; element sticks to the top
				$element.removeClass( elClassHidden );
			}

			else if( wScrollDiff > 0 && $element.hasClass( elClassHidden ) ) {// scrolled up; element slides in
				$element.removeClass( elClassHidden );
			}

			else if( wScrollDiff < 0 ) // scrolled down
			{
				if( wScrollCurrent + wHeight >= $('.main-content')[0].scrollHeight-100 && $element.hasClass( elClassHidden ) ) // scrolled to the very bottom (minus 200px); element slides in
					{
						$element.removeClass( elClassHidden );
					}

				else {// scrolled down; element slides out
					$element.addClass( elClassHidden );
				}
			}

			wScrollBefore = wScrollCurrent;
		}));

	})( jQuery, window, document );
</script>


		@yield('scripts')
	</body>
</html>