<?php

namespace App\Http\Controllers;

use App\Episode;
use App\SerieVideo;

class EpisodeController extends Controller
{

    // delete an episode from the database
    public function destroy(Episode $episode)
    {
        if($episode != null){
            $episode->delete();

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

    // return videos for an episode
    public function videos(Episode $episode)
    {
        return response()->json($episode->videos, 200);
    }

    // remove a video from an episode
    public function destroyVideo(SerieVideo $video)
    {
        if($video != null){
            $video->delete();
            $data = [
                'status' => 200,
                'message' => 'successfully deleted ',
            ];
        }else{
            $data = [
                'status' => 400,
                'message' => 'could not be deleted',
            ];
        }

        return response()->json($data, $data['status']);
    }

    // add a view to an episode
    public function view(Episode $episode)
    {
        if($episode != null){
            $episode->views++;
            $episode->save();
            $data = [
                'status' => 200
            ];
        }else{
            $data = [
                'status' => 400
            ];
        }

        return response()->json($data, $data['status']);
    }
}
