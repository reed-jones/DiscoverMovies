<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favourite;
use Illuminate\Support\Facades\Auth;

class FavouritesController extends Controller
{
    //
    public function getAll()
    {
    	return view('favourites', [
            'favs' => Auth::user()->favourites
        ]);
    }

    public function editFavourite(Request $req)
    {
        // check if already exists
        $exists = Auth::user()
            ->favourites()
            ->where('movie_id', $req->movie_id);

        // if this user does not have this movie, add it.
        if($exists->count() == 0){

            // create a new favourite.
	    	$fav = new Favourite();

            // add attributes
	    	$fav->movie_id = $req->movie_id;
	    	$fav->movie_title = $req->movie_title;
	    	$fav->poster_path = $req->poster_path;

            Auth::user()
                ->favourites()
                ->save($fav);

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
