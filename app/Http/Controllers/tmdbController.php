<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
Use App\ApiKey;
use App\Favourite;
use Illuminate\Support\Facades\Auth;

class tmdbController extends Controller
{
    public function popularMovies()
    {
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

    public function filmography($personId)
    {
        $client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);

        $apikey = ApiKey::first()->api_key;

        $results = $client->request('GET', "person/{$personId}/combined_credits?&api_key={$apikey}");
        $filmography = json_decode($results->getBody())->cast;

        $results = $client->request('GET', "person/{$personId}?&api_key={$apikey}");
        $person = json_decode($results->getBody());

        return view('filmography', compact(['filmography', 'person', 'apikiey']));
    }

    public function singleMovie($movieId)
    {
        $client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
        $apikey = ApiKey::first()->api_key;

        $response = $client->request('GET', "movie/{$movieId}?api_key={$apikey}");
        $movie = json_decode($response->getBody());

        $response = $client->request('GET', "movie/{$movieId}/credits?api_key={$apikey}");
        $cast = json_decode($response->getBody())->cast;

        $response = $client->request('GET', "movie/{$movieId}/similar?api_key={$apikey}");
        $similar = json_decode($response->getBody())->results;

        $response = $client->request('GET', "movie/{$movieId}/recommendations?api_key={$apikey}");
        $recommendations = json_decode($response->getBody())->results;

        if(Auth::check()){
            $favBool = Auth::user()
                ->favourites()
                ->where('movie_id', $movie->id)
                ->exists();
        }

        return view('singleMovie', compact(['movie','cast','similar','recommendations', 'favBool']));
    }

    public function search(Request $req)
    {
        $client = new Client(['base_uri' => 'https://api.themoviedb.org/3/']);
        $apikey = ApiKey::first()->api_key;
        $request = $req->input('q');

        if(empty($request)){
            $results = [];
        } else {
            $response = $client->request('GET', "search/multi?query={$request}&api_key={$apikey}");
            $results = json_decode($response->getBody())->results;
        }

        return view('search', compact('results'));
    }
}
