<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class tmdbController extends Controller
{
    function popularMovies(){
    	$client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
        if (!\App\ApiKey::all()->isEmpty()){
        	$apikey = \App\ApiKey::first()->api_key;
            $response = $client->request('GET', "movie/popular?sort_by=popularity.desc&api_key=$apikey");
        }


        if(empty($apikey))
            return view('errors.404');

		return view('popular')->with('popularMovies', json_decode($response->getBody())->results)->with('apikey', $apikey);
    }

    function filmography($personid){
    	$client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);


    	$apikey = \App\ApiKey::first()->api_key;
    	//dd($apikey);
		$results = $client->request('GET', "person/$personid/combined_credits?&api_key=$apikey");
		$filmography = json_decode($results->getBody())->cast;

		$results = $client->request('GET', "person/$personid?&api_key=$apikey");
		$person = json_decode($results->getBody());

		return view('filmography')->with('filmography', $filmography)->with('person', $person)->with('apikey', $apikey);
    }

    function singleMovie($movieid){
    	$client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
    	$apikey = \App\ApiKey::first()->api_key;

    	$response = $client->request('GET', "movie/$movieid?api_key=$apikey");
    	$movie = json_decode($response->getBody());

    	$response = $client->request('GET', "movie/$movieid/credits?api_key=$apikey");
    	$cast = json_decode($response->getBody())->cast;
    	
    	$response = $client->request('GET', "movie/$movieid/similar?api_key=$apikey");
    	$similar = json_decode($response->getBody())->results;

    	$response = $client->request('GET', "movie/$movieid/recommendations?api_key=$apikey");
    	$recommendations = json_decode($response->getBody())->results;

        if(\Auth::check()){
        $favBool = \App\Favourite::where('user_id', \Auth::user()->id)
                    ->where('movie_id', $movie->id)->first();
        }

        return view('singleMovie', compact(['movie','cast','similar','recommendations', 'favBool']));
    	// return view('singleMovie')->with('movie', $movie)->with('cast', $cast)->with('similar', $similar)->with('recommendations', $recommendations);
    }

    function search(Request $req){
    	$request = $req->input('search');
    	$client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
    	$apikey = \App\ApiKey::first()->api_key;

    	if(empty($request)){
    		$request = "John Wick";
    	}

    	$response = $client->request('GET', "search/multi?query=$request&api_key=$apikey");
        // dd($response->getBody()->getContents());
    	$results = json_decode($response->getBody())->results;

        //$app = app();
        //$movieArray = $app->make('myMovieModel');
    	// return view('search');
    	return view('search')->with('results', $results);
    }

}
