{{-- Navbar, search etc --}}
@extends('layouts.movieAppPublic')

{{-- Card List --}}
@section('content')
	
<div class="site-header">
	<h1>Discover<wbr>Movies</h1>
	<h2>Having a hard time deciding what to watch?</h2>
	<p>We can help. Browse the most popular films or search for specific titles. Create an account and save your favourites for later.
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

(function($, window, undefined) {
    var InfiniteScroll = function() {
        this.initialize = function() {
            this.setupEvents();
        };
        
        this.setupEvents = function() {
            $('.main-content').on(
                'scroll',
                this.handleScroll.bind(this)
            );
        };
 
        this.handleScroll = function() {
            var scrollTop = $('.main-content').scrollTop();
            var windowHeight = $('.main-content').height();
            var height = $(document).height() - windowHeight;
            // var scrollPercentage = (scrollTop / height);
            var theTop = $('.main-content')[0].scrollHeight;
            var scrollPercentage = ((windowHeight+scrollTop+110)/theTop).toFixed(2);
          //  console.log(scrollPercentage);


            // if the scroll is more than 90% from the top, load more content.
            if(scrollPercentage > 0.95 && !loadingNew) {
                this.doSomething();
            }
        }
 
        this.doSomething = function() {
        	loadingNew = true;
            loadMore();
        }
 
        this.initialize();
    }
 
    $(document).ready(
        function() {
            // Initialize scroll
            new InfiniteScroll();
        }
    );
})(jQuery, window);


function loadMore(){
		$.ajax({
  method: "GET",
  url: "https://api.themoviedb.org/3/movie/popular?sort_by=popularity.desc&page="+ (++pageNumber)+"&api_key=" + "{{ $apikey }}"
})
  .done(function( results ) {
    display(results.results);
  })
}

function display(results) {
	$.each(results, function(index, movie) {
		var $li = $("<li>", {"class": "card-lg"})
					.append($("<a>", { "href": "/movie/"+movie.id })
					.append($("<div>", {
						"class": "card-lg-poster",
						"style": "background-image: url(https://image.tmdb.org/t/p/w154"+ movie.poster_path +");" }))
					.append($("<div>", {"class": "card-lg-info"})
						.append($("<div>", {"class": "movie"})
						.append($("<h3>", {"class": "movie-name"}).html(movie.title))
						.append($("<p>", {"class": "movie-rating"}).html("Rating: " +movie.vote_average + " | " + movie.release_date))
						.append($("<p>", {"class": "movie-overview"}).html(movie.overview)))));
		$('#load-more').before($li);
	})
    loadingNew = false;
}
</script>
@endsection