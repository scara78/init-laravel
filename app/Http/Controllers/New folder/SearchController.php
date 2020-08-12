<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Serie;
use App\Livetv;
use App\Genre;

class SearchController extends Controller
{
    // returns all the movies, series and livetv that match the search
    public function index($query)
    {
        $movies = Movie::where('title', 'LIKE', "%$query%")->limit(10)->get();
        $series = Serie::where('name', 'LIKE', "%$query%")->limit(10)->get();
        $livetv = Livetv::where('name', 'LIKE', "%$query%")->limit(10)->get();

        $data = [
            'movies' => $movies,
            'series' => $series,
            'livetvs' => $livetv
        ];

        return response()->json($data, 200);
    }
}
