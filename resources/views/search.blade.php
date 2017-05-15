{{-- Navbar, search etc --}}
@extends('layouts.movieAppPublic')

{{-- Card List --}}
@section('content')
<?php

$movieString = "";
$tvString = "";
$personString = "";
foreach($results as $result){
	if ($result->media_type === "movie" ){
		if(empty($result->poster_path) || empty($result->title)) {
			continue;
		}

		$movieString .= '<li><a href="/movie/'.$result->id.'" class="card movie">';
		$movieString .= '<div class="card-image" style="background-image: url(';
		$movieString .= isset($result->poster_path) ? 'https://image.tmdb.org/t/p/w185' . $result->poster_path : '';
		$movieString .= ')"></div><div class="card-title">';
		$movieString .= isset($result->title) ? $result->title : 'Unknown';
		$movieString .= '</div><div class="card-subtitle">';
		$movieString .= isset($result->release_date) ? $result->release_date : 'Unknown';
		$movieString .= '</div></a></li>';
	} elseif ($result->media_type === "tv" ) {
		if(empty($result->poster_path) || empty($result->name)) {
			continue;
		}

		$tvString .= '<li>';
		$tvString .= '<div class="card tvshow"><div class="card-image" style="background-image: url(';
		$tvString .= isset($result->poster_path) ?'https://image.tmdb.org/t/p/w185' . $result->poster_path : '';
		$tvString .= ')"></div><div class="card-title">';
		$tvString .= isset($result->name) ? $result->name : 'Unknown';
		$tvString .= '</div><div class="card-subtitle">';
		$tvString .= isset($result->first_air_date) ? $result->first_air_date : 'Unknown';
		$tvString .= '</div></div></li>'; 
	} elseif ($result->media_type === "person" ) {
		if(empty($result->profile_path) || empty($result->name)) {
			continue;
		}

		$personString .= '<li><a href="/person/'.$result->id .'"  class="card person">';
		$personString .= '<div class="card-image" style="background-image: url(';
		$personString .= isset($result->profile_path) ?'https://image.tmdb.org/t/p/w185' . $result->profile_path : '';
		$personString .= ')"></div><div class="card-title">';
		$personString .= isset($result->name) ? $result->name : 'Unknown';
		$personString .= '</div>';

		//dd($result->known_for);
			    foreach($result->known_for as $film){

			    	if (isset($film->title)) {
				    	$personString .= '<div class="card-subtitle">' . $film->title . '</div>';
				    } elseif (isset($film->name)) {
				    	$personString .= '<div class="card-subtitle">' . $film->name . '</div>';
				    }
			    }
		$personString .= '</a></li>';
	}	
}

echo '<div class="card-list">';
if(!empty($movieString)){
echo '<br><h3 class="search-result-header">Movies</h3><br>';
echo '<ul class="card-sm left_align">';
echo $movieString;
echo '</ul>';
}

if(!empty($tvString)){
echo '<br><h3 class="search-result-header">TV</h3><br>';
echo '<ul class="card-sm left_align">';
echo $tvString;
echo '</ul>';
}

if(!empty($personString)){
echo '<br><h3 class="search-result-header">People</h3><br>';
echo '<ul class="card-sm left_align">';
echo $personString;
echo '</ul>';
}
echo '</div>';

?>
@endsection