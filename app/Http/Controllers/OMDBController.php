<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Controllers\MovieController;

class OMDBController extends Controller
{
    //
    public function getMovieCollection($title="love", $year="2020", $type="movie"){
        $movieController =  new MovieController();
        $totalPages = 1;
        $currentPage = 1; 
        do{
            $patch = config('app.url_OMDB')."/?apikey=".config('app.key_OMDB')."&s=$title&y=$year&type=$type&page=$currentPage";
            $result = file_get_contents($patch);
            $movies = json_decode($result, true);
            foreach ($movies['Search'] as $movie){
                $movieController->save($movie);
            }
            if ($totalPages != ceil($movies['totalResults']/10)){
                $totalPages = ceil($movies['totalResults']/10);
            }
            $currentPage++;
            // var_dump($movies);
        }
        while($currentPage <= $totalPages);

        return redirect('/');
    }

    


}
