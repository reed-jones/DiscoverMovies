<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
Use \App\ApiKey;

class tmdbController extends Controller
{
    function popularMovies(){
    	$client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
        if (!ApiKey::all()->isEmpty()){
        	$apikey = ApiKey::first()->api_key;
            $response = $client->request('GET', "movie/popular?sort_by=popularity.desc&api_key=$apikey");
        }


        if(empty($apikey)){
            return view('errors.404');
        }

        $popularMovies = json_decode($response->getBody())->results;

		return view('popular', compact(['popularMovies', 'apikey']));
    }

    function filmography($personid){
    	$client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);

    	$apikey = ApiKey::first()->api_key;
    	//dd($apikey);
		$results = $client->request('GET', "person/$personid/combined_credits?&api_key=$apikey");
		$filmography = json_decode($results->getBody())->cast;

		$results = $client->request('GET', "person/$personid?&api_key=$apikey");
		$person = json_decode($results->getBody());

		return view('filmography', compact(['filmography', 'person', 'apikiey']));
    }

    function singleMovie($movieid){
    	$client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
    	$apikey = ApiKey::first()->api_key;

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
        // $data = compact(['movie','cast','similar','recommendations', 'favBool']);
        // return view('singleMovie', compact('data'));

        return view('singleMovie', compact(['movie','cast','similar','recommendations', 'favBool']));
    }

    function search(Request $req){
        $client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
        $apikey = ApiKey::first()->api_key;
    	$request = $req->input('q');

    	if(empty($request)){
    		$results = array();
    	} else {
        	$response = $client->request('GET', "search/multi?query=$request&api_key=$apikey");
        	$results = json_decode($response->getBody())->results;
        }
        
    	return view('search', compact('results'));
    }
}
