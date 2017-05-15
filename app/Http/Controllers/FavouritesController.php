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

    function editFavourite(Request $req){
    	// check if alread exists
    	$exists = Favourite::where('user_id', $req->user_id)
    			->where('movie_id', $req->movie_id);

        // if this user does not have this movie, add it.
    	if($exists->count() == 0){

            // create a new favourite.
	    	$fav = new Favourite();

            // add attributes
	    	$fav->user_id = $req->user_id;
	    	$fav->movie_id = $req->movie_id;
	    	$fav->movie_title = $req->movie_title;
	    	$fav->poster_path = $req->poster_path;

	    	$fav->save();
            return "Added";

        // if this user has this movie, delete it.
	    } else if ($exists->count() == 1) {

            $exists->delete();
            return "Deleted";
        }

        // if for whatever reason this runs. uh oh.
        return "Error";
    }
}
