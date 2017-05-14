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
			if( wScrollCurrent + wHeight >= $('.main-content')[0].scrollHeight-110 && $element.hasClass( elClassHidden ) ) // scrolled to the very bottom (minus 100px for padding); element slides in
				{
					// choosing infinity scroll instead
					//$element.removeClass( elClassHidden );
				}

			else {// scrolled down; element slides out
				$element.addClass( elClassHidden );
			}
		}
		wScrollBefore = wScrollCurrent;
	}));
})( jQuery, window, document );