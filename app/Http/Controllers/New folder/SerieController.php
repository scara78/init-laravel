<?php

namespace App\Http\Controllers;

use App\Serie;
use App\SerieGenre;
use App\Genre;
use App\Season;
use App\Episode;
use App\SerieVideo;
use App\Embed;
use App\Http\Requests\SerieStoreRequest;
use App\Http\Requests\SerieUpdateRequest;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Jobs\SendNotification;


class SerieController extends Controller
{
    // returns all series except children series, for api.
    public function index()
    {
        $series = Serie::whereDoesntHave('genres', function ($genre) {
            $genre->where('genre_id', '=', 10762);
        })->orderByDesc('id')->paginate(12);

        return response()->json($series, 200);
    }

    // returns all series for admin panel
    public function data()
    {
        return response()->json(Serie::with('seasons.episodes.videos')->get(), 200);
    }

    // returns a specific serie
    public function show(Serie $serie)
    {
        return response()->json($serie, 200);
    }


    // create a new serie in the database
    public function store(SerieStoreRequest $request)
    {
        $serie = new Serie();
        $serie->fill($request->serie);
        $serie->save();

        if ($request->serie['genres']) {
            foreach ($request->serie['genres'] as $genre) {
                $find = Genre::find($genre['id']);
                if ($find == null) {
                    $find = new Genre();
                    $find->fill($genre);
                    $find->save();
                }
                $serieGenre = new SerieGenre();
                $serieGenre->genre_id = $genre['id'];
                $serieGenre->serie_id = $serie->id;
                $serieGenre->save();
            }
        }

        if ($request->serie['seasons']) {
            foreach ($request->serie['seasons'] as $reqSeason) {
                $season = new Season();
                $season->fill($reqSeason);
                $season->serie_id = $serie->id;
                $season->save();
                if ($reqSeason['episodes']) {
                    foreach ($reqSeason['episodes'] as $reqEpisode) {
                        $episode = new Episode();
                        $episode->fill($reqEpisode);
                        $episode->season_id = $season->id;
                        $episode->save();
                        if (isset($reqEpisode['videos'])) {
                            foreach ($reqEpisode['videos'] as $reqVideo) {
                                if (!filter_var($reqVideo['link'], FILTER_VALIDATE_URL)) { 
                                    $embed = new Embed();
                                    $embed->code =  $reqVideo['link'];
                                    $embed->save();
                                    $reqVideo['link'] = $request->root() . '/api/embeds/show/' . $embed->id;
                                }
                                $video = new SerieVideo();
                                $video->fill($reqVideo);
                                $video->episode_id = $episode->id;
                                $video->save();
                            }
                        }
                    }
                }
            }
        }

        if($request->notification){
            $this->dispatch(new SendNotification($serie));
        }

        $data = [
            'status' => 200,
            'message' => 'successfully created',
            'body' => $serie->load('seasons.episodes.videos')
        ];

        return response()->json($data, $data['status']);
    }

    // update a serie in the database
    public function update(SerieUpdateRequest $request, Serie $serie)
    {
        $serie->fill($request->serie);
        $serie->save();

        if ($request->serie['genres']) {
            foreach ($request->serie['genres'] as $genre) {
                if (!isset($genre['genre_id'])) {
                    $find = Genre::find($genre['id']) ?? new Genre();
                    $find->fill($genre);
                    $find->save();
                    $serieGenre = SerieGenre::where('serie_id', $serie->id)->where('genre_id', $genre['id'])->get();
                    if (count($serieGenre) < 1) {
                        $serieGenre = new SerieGenre();
                        $serieGenre->genre_id = $genre['id'];
                        $serieGenre->serie_id = $serie->id;
                        $serieGenre->save();
                    }
                }
            }
        }

        if ($request->serie['seasons']) {
            foreach ($request->serie['seasons'] as $reqSeason) {
                $season = Season::find($reqSeason['id'] ?? 0) ?? new Season();
                $season->fill($reqSeason);
                $season->serie_id = $serie->id;
                $season->save();
                if ($reqSeason['episodes']) {
                    foreach ($reqSeason['episodes'] as $reqEpisode) {
                        $episode = Episode::find($reqEpisode['id'] ?? 0) ?? new Episode();
                        $episode->fill($reqEpisode);
                        $episode->season_id = $season->id;
                        $episode->save();
                        if (isset($reqEpisode['videos'])) {
                            foreach ($reqEpisode['videos'] as $reqVideo) {
                                if (!filter_var($reqVideo['link'], FILTER_VALIDATE_URL)) { 
                                    $embed = new Embed();
                                    $embed->code =  $reqVideo['link'];
                                    $embed->save();
                                    $reqVideo['link'] = $request->root() . '/api/embeds/show/' . $embed->id;
                                }
                                $video = SerieVideo::find($reqVideo['id'] ?? 0) ?? new SerieVideo();
                                $video->fill($reqVideo);
                                $video->episode_id = $episode->id;
                                $video->save();
                            }
                        }
                    }
                }
            }
        }

        $data = [
            'status' => 200,
            'message' => 'successfully updated',
            'body' => Serie::all()
        ];

        return response()->json($data, $data['status']);
    }

    // delete a serie from the database
    public function destroy(Serie $serie)
    {
        if($serie != null){
            $serie->delete();

            $data = [
                'status' => 200,
                'message' => 'successfully deleted',
            ];
        }else{
            $data = [
                'status' => 400,
                'message' => 'could not be deleted',
            ];
        }
       

        return response()->json($data, $data['status']);
    }

    // remove a genre from a series from the database
    public function destroyGenre(SerieGenre $genre)
    {
        if($genre != null){
            $genre->delete();
            $data = [
                'status' => 200,
                'message' => 'successfully deleted',
            ];
        }else{
            $data = [
                'status' => 400,
                'message' => 'could not be deleted',
            ];
        }
        
        return response()->json($data, $data['status']);
    }

    // save a new image in the series folder of the storage
    public function storeImg(StoreImageRequest $request)
    {

        if ($request->hasFile('image')) {
            $filename = Storage::disk('series')->put('', $request->image);
            $data = [
                'status' => 200,
                'image_path' => $request->root() . '/api/series/image/' . $filename,
                'message' => 'image uploaded successfully'
            ];
        } else {
            $data = [
                'status' => 400,
                'message' => 'there was an error uploading the image'
            ];
        }

        return response()->json($data, $data['status']);
    }

    // return an image from the series folder of the storage
    public function getImg($filename)
    {

        $image = Storage::disk('series')->get($filename);

        $mime = Storage::disk('series')->mimeType($filename);

        return (new Response($image, 200))
            ->header('Content-Type', $mime);
    }

    // returns all the series for children
    public function kids()
    {
        $series = Serie::whereHas('genres', function ($genre) {
            $genre->where('genre_id', '=', 10762);
        })->orderByDesc('id')->paginate(12);

        return response()->json($series, 200);
    }

    // return the 10 series with the highest average votes
    public function recommended()
    {
        $series = Serie::orderByDesc('vote_average')->limit(10)->get();

        return response()->json($series, 200);
    }

    // return the 10 movies with the most popularity
    public function popular()
    {
        $series = Serie::orderByDesc('popularity')->limit(10)->get();

        return response()->json($series, 200);
    }

    // returns the last 10 series added in the month
    public function recents()
    {
        $series = Serie::where('created_at', '>', Carbon::now()->subMonth())->orderByDesc('created_at')->limit(10)->get();

        return response()->json($series, 200);
    }

    // returns 12 series related to a serie
    public function relateds(Serie $serie)
    {
        $genre = $serie->genres[0]->genre_id;

        $series = SerieGenre::where('genre_id', $genre)->where('serie_id', '!=', $serie->id)->limit(12)->get();
        $series->load('serie');
        $relateds = [];
        foreach ($series as $item) {
            array_push($relateds, $item['serie']);
        }

        return response()->json($relateds, 200);
    }
}
