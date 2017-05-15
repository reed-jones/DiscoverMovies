{{-- Navbar, search etc --}}
@extends('layouts.movieAppPublic')

{{-- Card List --}}
@section('content')
	
<div class="site-header">
	<h1>Discover<wbr>Movies</h1>
	<h2>Having a hard time deciding what to watch?</h2>
	<p>We can help. Browse the most popular films or search for specific titles. Create an account and save your favourites for later.</p>
</div>

<ul class="card-list">
	@foreach($popularMovies as $movie)
		<li class="card-lg">
			<a href="/movie/{{ $movie->id }}">
				<div class="card-lg-poster" style="background-image: url(https://image.tmdb.org/t/p/w154{{ $movie->poster_path }});"></div>
				<div class="card-lg-info">
					<div class="movie">
						<h3 class="movie-name">{{ $movie->title }}</h3>
						<p class="movie-rating">Rating: {{ $movie->vote_average }} | {{ $movie->release_date }}</p>
						<p class="movie-overview">{{ $movie->overview }}</p>
					</div>
				</div>
			</a>
		</li>
	@endforeach
		<li class="card-lg" id="load-more">
			<a href="#" onclick="event.preventDefault(); loadMore();">
				<div class="card-lg-poster"></div>
				<div class="card-lg-info">
					<div class="movie">
						<h3 class="movie-name">Load More</h3>
						<p class="movie-rating"></p>
						<p class="movie-overview">It appears you have reached the end.</p>
					</div>
				</div>
			</a>
		</li>
</ul>
@endsection

@section('scripts')
<script>
var pageNumber = 1;
var loadingNew = false;
var windowHeight = $('.main-content').height();
var scrollIntervalID = setInterval(infinityScroll, 100);

/**
 * Poll the scroll distance to determine if
 * new page of results should be loaded
 */
function infinityScroll(){
	var scrollTop = $('.main-content').scrollTop(),
        theTop = $('.main-content')[0].scrollHeight,
        scrollRemaining = (theTop - (windowHeight+scrollTop));

    // if the scroll is more than 90% from the top, load more content.
    if(scrollRemaining <= 400 && !loadingNew) {
        loadMore();
    }
}

/**
 * AJAX request to return next page of results
 */
function loadMore(){
	$.ajax({
  		method: "GET",
  		url: "https://api.themoviedb.org/3/movie/popular?sort_by=popularity.desc&page="+ (++pageNumber)+"&api_key=" + "{{ $apikey }}"
	}).done(function( results ) {
		display(results.results);
	}).fail(function(){
		//display error that next page could not be loaded
		//perhaps inform the user they have reached the end of the internet.
	})
}

/**
 * Construct all the newly aquired cards.
 */
function display(results) {
	// stops loading of million pages when botom is reached
	loadingNew = true;
	console.log("loading page " + pageNumber);

	// just look at this mess
	// no comment...
	$.each(results, function(index, movie) {

		// create the movie card.
		// TODO check if values are null first
		var $li = $("<li>", {"class": "card-lg"})
			.append($("<a>", { "href": "/movie/"+movie.id })
				.append($("<div>", { "class": "card-lg-poster",
					"style": "background-image: url(https://image.tmdb.org/t/p/w154"+ movie.poster_path +");" }))
				.append($("<div>", {"class": "card-lg-info"})
					.append($("<div>", {"class": "movie"})
						.append($("<h3>", {"class": "movie-name"}).html(movie.title))
						.append($("<p>", {"class": "movie-rating"}).html("Rating: " +movie.vote_average + " | " + movie.release_date))
						.append($("<p>", {"class": "movie-overview"}).html(movie.overview)))));

		// add it before the "final" card.
		$('#load-more').before($li);
	})

	// thats all folks
    loadingNew = false;
}
</script>
@endsection