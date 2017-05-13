{{-- Navbar, search etc --}}
@extends('layouts.movieAppPublic')
@php 
	$orig = $movie;
@endphp

{{-- Card List --}}
@section('content')
        <div class="card-details">
			<div class="card-details-top" style="background-image: url({{ isset($movie->backdrop_path) ?'https://image.tmdb.org/t/p/w780' . $movie->backdrop_path : ''}})">
				<div class="full-poster" style="background-image: url({{ isset($movie->poster_path) ?'https://image.tmdb.org/t/p/w154' . $movie->poster_path : ''}})"></div>
				<div class="full-movie">
					<p class="full-movie-title">{{ $movie->title }}</p>
					<p class="full-movie-subtitle">{{ isset($movie->tagline) ? $movie->tagline : '' }}</p>
					<p class="full-movie-details">{{ $movie->release_date }} | {{ $movie->runtime }} minutes</p>
					<p class="full-movie-rating">Rating: {{ $movie->vote_average }}</p>
				</div>
				@if(Auth::check())
					<div class="favstar">
						@if(!isset($favBool))
							<div class="filledstar"></div>
						@endif
					</div>
				@endif
	                    
			</div>
			<div class="card-details-bottom">
				<p class="movie-overview">{{ $movie->overview }}</p>
				<h3>Cast</h3>
				<div class="card-scroll">
                    <ul class="card-sm">
					@for($i = 0; $i < 9; $i++)
					@if (!empty($cast[$i]))
                        <li>
							<a href="/person/{{ $cast[$i]->id }}">
								<div class="card person">
									<div class="card-image"
									style="background-image: url({{ isset($cast[$i]->profile_path) ?'https://image.tmdb.org/t/p/w185' . $cast[$i]->profile_path : ''}})">
									</div>
									<div class="card-title">{{ $cast[$i]->name }}</div>
									<div class="card-subtitle">{{ $cast[$i]->character}}</div>
								</div>
							</a>
                        </li>
					@endif
					@endfor
                    </ul>
				</div>
				<h3>Recommendations</h3>
				<div class="card-scroll">
                    <ul class="card-sm">
					@foreach($recommendations as $movie)
                        <li>
							<a href="/movie/{{ $movie->id }}">
								<div class="card movie">
									<div class="card-image"
									style="background-image: url({{ isset($movie->poster_path) ?'https://image.tmdb.org/t/p/w185' . $movie->poster_path : ''}})">
									</div>
									<div class="card-title">{{ $movie->title }}</div>
								</div>
							</a>
                        </li>
					@endforeach
                    </ul>
				</div>
				<h3>Similar Movies</h3>
				<div class="card-scroll">
                    <ul class="card-sm">
					@foreach($similar as $movie)
                        <li>
							<a href="/movie/{{ $movie->id }}">
								<div class="card movie">
									<div class="card-image"
									style="background-image: url({{ isset($movie->poster_path) ?'https://image.tmdb.org/t/p/w185' . $movie->poster_path : ''}})">
									</div>
									<div class="card-title">{{ $movie->title }}</div>
								</div>
							</a>
                        </li>
					@endforeach
                    </ul>
				</div>
			</div>
		</div>
@endsection


@section('scripts')

    {{-- @include('scripts.jQuery') --}}


    @include('scripts.horizontalScroll')
    <script>

@if (Auth::check())
    $('.favstar').click(function(){
		$.ajax({
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			method: "POST",
			url: '/savefav',
			data:{
				user_id: "{{ Auth::user()->id }}",
				movie_id: "{{ $orig->id }}",
				movie_title: "{{ $orig->title }}",
				poster_path: "{{ $orig->poster_path }}"

			}
		}).done(function(msg){
				$('.filledstar').css('display', 'none');
			});
	});

@endif
    </script>

    <script type="text/javascript">
    // subscribe to horizontal scroll on cards
    $(function() {
       $(".card-scroll .card-sm").mousewheel(function(event, delta) {
          this.scrollLeft -= (delta * 30);
          event.preventDefault();
       });
    });

    // auto scroll cast column to highlight animations
    $(document).ready(function(){
        $(".card-scroll .card-sm")[0].scrollLeft = $(".card-scroll .card-sm")[0].scrollWidth;

       var one = setInterval(function() {
            if ($(".card-scroll .card-sm")[0].scrollLeft < 1){
                clearInterval(one);
            }
            $(".card-scroll .card-sm")[0].scrollLeft -= 2;
        }, 10);
    });
    </script>
    
@endsection