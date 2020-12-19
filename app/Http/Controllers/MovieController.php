<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Resources\MovieResource;

class MovieController extends Controller
{
    //
    public function save($objMovie){

        $movie = Movie::where('imdbID', $objMovie['imdbID'])->first();
        
        if($movie == null){
            $movie = new Movie();
        }

        $movie->name = $objMovie['Title'];
        $movie->imdbID = $objMovie['imdbID'];
        $movie->year = (int)$objMovie['Year'];
        $movie->type = $objMovie['Type'];
        $movie->image_url = $objMovie['Poster']; 

        $movie->save();
        
    }

    public function getMovies(){
        $movies = Movie::all();
        return MovieResource::collection($movies);
    }
}
