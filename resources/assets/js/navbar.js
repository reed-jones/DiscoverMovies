var scrollIntervalID = setInterval(hideNavBar, 300);
var prevPosition = 0;
/**
 * Hides the navbar on scroll down. Reveals the navbar
 * on scroll up. uses a half second delay for performance
 * and a bit of a nice "lazy" feel.
 */
function hideNavBar(){
	var scrollTop = $('.main-content').scrollTop();

	if (scrollTop > prevPosition){
		$('.nav').addClass('gone');
	} else if (scrollTop < prevPosition) {
		$('.nav').removeClass('gone');
	}
	prevPosition = scrollTop;
}