

document.getElementById('input_search').onfocus = function () {
	document.getElementById('search').classList.add('activeSearch');
};
document.getElementById('input_search').onblur = function () {
	document.getElementById('search').classList.remove('activeSearch');
};

try {
    window.$ = window.jQuery = require('jquery');

    require('./navbar');
    require('./horizontalScroll');
} catch (e) {}

