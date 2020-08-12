<?php

namespace App\Http\Controllers;

use App\Movie;
use App\MovieVideo;
use App\MovieGenre;
use App\Genre;
use App\Embed;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Jobs\SendNotification;
use App\Http\Requests\MovieStoreRequest;
use App\Http\Requests\MovieUpdateRequest;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // return all the movies for the api
    public function index()
    {
        return response()->json(Movie::orderByDesc('id')->paginate(12), 200);
    }

    // return all the movies for the admin panel
    public function data()
    {
        return response()->json(Movie::all(), 200);
    }

    // create a new movie in the database
    public function store(MovieStoreRequest $request)
    {
        $movie = new Movie();
        $movie->fill($request->movie);
        $movie->save();

        if ($request->links) {
            foreach ($request->links as $link) {
                if (!filter_var($link['link'], FILTER_VALIDATE_URL)) { 
                    $embed = new Embed();
                    $embed->code =  $link['link'];
                    $embed->save();
                    $link['link'] = $request->root() . '/api/embeds/show/' . $embed->id;
                }
                $movieVideo = new MovieVideo();
                $movieVideo->fill($link);
                $movieVideo->movie_id = $movie->id;
                $movieVideo->save();
            }
        }

        if ($request->movie['genres']) {
            foreach ($request->movie['genres'] as $genre) {
                $find = Genre::find($genre['id']);
                if ($find == null) {
                    $find = new Genre();
                    $find->fill($genre);
                    $find->save();
                }
                $movieGenre = new MovieGenre();
                $movieGenre->genre_id = $genre['id'];
                $movieGenre->movie_id = $movie->id;
                $movieGenre->save();
            }
        }

        if ($request->notification) {
            $this->dispatch(new SendNotification($movie));
        }

        $data = [
            'status' => 200,
            'message' => 'created successfully',
            'body' => $movie
        ];

        return response()->json($data, $data['status']);
    }

    // returns a especific movie
    public function show(Movie $movie)
    {
        return response()->json($movie, 200);
    }

    // add a view to a movie
    public function view(Movie $movie)
    {
        if ($movie != null) {
            $movie->views++;
            $movie->save();
            $data = [
                'status' => 200,
            ];
        } else {
            $data = [
                'status' => 400,
            ];
        }

        return response()->json($data, $data['status']);
    }

    // update a movie in the database
    public function update(MovieUpdateRequest $request, Movie $movie)
    {
        $movie->fill($request->movie);
        $movie->save();

        if ($request->links) {
            foreach ($request->links as $link) {
                if (!isset($link['id'])) {
                    if (!filter_var($link['link'], FILTER_VALIDATE_URL)) { 
                        $embed = new Embed();
                        $embed->code =  $link['link'];
                        $embed->save();
                        $link['link'] = $request->root() . '/api/embeds/show/' . $embed->id;
                    }
                    $movieVideo = new MovieVideo();
                    $movieVideo->movie_id = $movie->id;
                    $movieVideo->fill($link);
                    $movieVideo->save();
                }
            }
        }

        if ($request->movie['genres']) {
            foreach ($request->movie['genres'] as $genre) {
                if (!isset($genre['genre_id'])) {
                    $find = Genre::find($genre['id'] ?? 0) ?? new Genre();
                    $find->fill($genre);
                    $find->save();
                    $movieGenre = MovieGenre::where('movie_id', $movie->id)->where('genre_id', $genre['id'])->get();
                    if (count($movieGenre) < 1) {
                        $movieGenre = new MovieGenre();
                        $movieGenre->genre_id = $genre['id'];
                        $movieGenre->movie_id = $movie->id;
                        $movieGenre->save();
                    }
                }
            }
        }

        $data = [
            'status' => 200,
            'message' => 'successfully updated',
            'body' => Movie::all()
        ];

        return response()->json($data, $data['status']);
    }

    // delete a movie in the database
    public function destroy(Movie $movie)
    {
        if ($movie != null) {
            $movie->delete();

            $data = [
                'status' => 200,
                'message' => 'successfully removed',
            ];
        } else {
            $data = [
                'status' => 400,
                'message' => 'could not be deleted',
            ];
        }

        return response()->json($data, $data['status']);
    }

    // remove the genre of a movie from the database
    public function destroyGenre(MovieGenre $genre)
    {
        if ($genre != null) {
            $genre->delete();
            $data = [
                'status' => 200,
                'message' => 'deleted successfully',
            ];
        } else {
            $data = [
                'status' => 400,
                'message' => 'could not be deleted',
            ];
        }

        return response()->json($data, $data['status']);
    }

    // save a new image in the movies folder of the storage
    public function storeImg(StoreImageRequest $request)
    {
        if ($request->hasFile('image')) {
            $filename = Storage::disk('movies')->put('', $request->image);
            $data = [
                'status' => 200,
                'image_path' => $request->root() . '/api/movies/image/' . $filename,
                'message' => 'successfully uploaded'
            ];
        } else {
            $data = [
                'status' => 400,
                'message' => 'could not be uploaded'
            ];
        }

        return response()->json($data, $data['status']);
    }

    // return an image from the movies folder of the storage
    public function getImg($filename)
    {

        $image = Storage::disk('movies')->get($filename);

        $mime = Storage::disk('movies')->mimeType($filename);

        return (new Response($image, 200))
            ->header('Content-Type', $mime);
    }

    // remove a video from a movie from the database
    public function videoDestroy(MovieVideo $video)
    {
        if ($video != null) {
            $video->delete();

            $data = [
                'status' => 200,
                'message' => 'successfully deleted',
            ];
        } else {
            $data = [
                'status' => 400,
                'message' => 'could not be deleted',
            ];
        }

        return response()->json($data, 200);
    }

    // returns 10 movies with a release date of less than 6 months
    public function latest()
    {
        $movies = Movie::where('release_date', '>', Carbon::Now()->subMonths(6))->orderByDesc('release_date')->limit(10)->get();

        return response()->json($movies, 200);
    }

    // return the 10 movies with the highest average votes
    public function recommended()
    {
        $movies = Movie::orderByDesc('vote_average')->limit(10)->get();

        return response()->json($movies, 200);
    }

    // return the 10 movies with the most popularity
    public function popular()
    {
        $movies = Movie::orderByDesc('popularity')->limit(10)->get();

        return response()->json($movies, 200);
    }

    // returns the last 10 movies added in the month
    public function recents()
    {
        $movies = Movie::where('created_at', '>', Carbon::now()->subMonth())->orderByDesc('created_at')->limit(10)->get();

        return response()->json($movies, 200);
    }

    // returns 12 movies related to a movie
    public function relateds(Movie $movie)
    { 
        $genre = $movie->genres[0]->genre_id;
        $movies = MovieGenre::where('genre_id', $genre)->where('movie_id', '!=', $movie->id)->limit(12)->get();
        $movies->load('movie');
        $relateds = [];
        foreach ($movies as $item) {
            array_push($relateds, $item['movie']);
        }

        return response()->json($relateds, 200);
    }

    // returns all the movies for children
    public function kids()
    {
        $movies = Movie::whereHas('genres', function ($genre) {
            $genre->where('genre_id', '=', 16);
        })->paginate(12);

        return response()->json($movies, 200);
    }

    // return all the videos of a movie
    public function videos(Movie $movie)
    {
        return response()->json($movie->videos, 200);
    }
}
