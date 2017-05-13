<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favourite;
use DB;

class FavouritesController extends Controller
{
    //
    function getAll(Request $req){
    	$favs = Favourite::where('user_id',  \Auth::user()->id)->get();

    	return view('favs', compact('request', 'favs'));
    }

    function saveFavourite(Request $req){
    	// should look into firstOrCreate firstOrNew and updateOdCreate
    	
    	// check if alread exists
    	$exists = Favourite::where('user_id', $req->user_id)
    			->where('movie_id', $req->movie_id)->count();

    	if(!$exists){
	    	$fav = new Favourite();

	    	$fav->user_id = $req->user_id;
	    	$fav->movie_id = $req->movie_id;
	    	$fav->movie_title = $req->movie_title;
	    	$fav->poster_path = $req->poster_path;

	    	$fav->save();
	    }

    }
}
