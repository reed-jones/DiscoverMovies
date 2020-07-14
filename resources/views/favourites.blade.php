{{-- Navbar, search etc --}}
@extends('layouts.movieAppPublic')

{{-- Card List --}}
@section('content')
<div class="card-list">
    <ul class="card-sm">
        @foreach($favs as $video)
        <li>
            <a href="/movie/{{ $video->movie_id }}">
                <div class="card movie">
                    <div class="card-image"
                    style="background-image: url({{ isset($video->poster_path) ?'https://image.tmdb.org/t/p/w185' . $video->poster_path : ''}})"></div>
                    <div class="card-title">{{ $video->movie_title or 'Unknown' }}</div>
                    <div class="card-subtitle">{{ $video->personal_rating or '' }}</div>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endsection
