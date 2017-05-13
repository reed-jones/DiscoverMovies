{{-- Navbar, search etc --}}
@extends('layouts.movieAppPublic')

{{-- Card List --}}
@section('content')
<ul class="card-list">
	@foreach($popularMovies as $movie)
		<li class="card-lg">
			<a href="/movie/{{ $movie->id }}">
				<div class="card-lg-poster" style="background-image: url(https://image.tmdb.org/t/p/w154{{ $movie->poster_path }});"></div>
				<div class="card-lg-info">
					<div class="movie">
						<p class="movie-name">{{ $movie->title }}</p>
						<p class="movie-rating">Rating: {{ $movie->vote_average }} | {{ $movie->release_date }}</p>
						<p class="movie-overview">{{ $movie->overview }}</p>
					</div>
				</div>
			</a>
		</li>
	@endforeach
	{{-- @include('pieces.footer') --}}
</ul>
@endsection