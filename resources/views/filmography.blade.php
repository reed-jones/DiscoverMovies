{{-- Navbar, search etc --}}
@extends('layouts.movieAppPublic')

{{-- Card List --}}
@section('content')
<div class="card-list">
	<ul class="card-sm">
		<li class="card bio person">
		    <div class="card-image" style="background-image: url(https://image.tmdb.org/t/p/w185{{ $person->profile_path }})"></div>
		    <div class="card-title">{{ $person->name or 'Unknown' }}</div>
		    <div class="card-subtitle">{{ $person->birthday or 'Unknown' }}</div>
	    </li>

		@foreach($filmography as $video)
		@if (isset($video->title) && isset($video->id) && isset($video->poster_path))
		<li>
			<a href="/movie/{{ $video->id }}">
			    <div class="card movie">
				    <div class="card-image" 
				    style="background-image: url({{ isset($video->poster_path) ?'https://image.tmdb.org/t/p/w185' . $video->poster_path : ''}})"></div>
				    <div class="card-title">{{ $video->title or 'Unknown' }}</div>
				    <div class="card-subtitle">{{ $video->release_date or 'Unknown' }}</div>
			    </div>
			</a>
		</li>
		@endif
		@endforeach
	</ul>
</div>
@endsection