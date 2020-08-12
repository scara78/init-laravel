<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Http\Requests\VideoRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    // save a new video in AWS S3 or the videos disk of the storage
    public function store(VideoRequest $request)
    {
        if ($request->hasFile('video')) {

            $settings = Setting::first();

            if ($settings->aws_s3_storage) {
                if (
                    $settings->aws_access_key_id != null &&
                    $settings->aws_secret_access_key != null &&
                    $settings->aws_default_region != null &&
                    $settings->aws_bucket != null
                ) {
                    config(['filesystems.disks.s3.key' => $settings->aws_access_key_id]);
                    config(['filesystems.disks.s3.secret' => $settings->aws_secret_access_key]);
                    config(['filesystems.disks.s3.region' => $settings->aws_default_region]);
                    config(['filesystems.disks.s3.bucket' => $settings->aws_bucket]);
                    
                    $filename = Storage::disk('s3')->put('', $request->video);
                    $url = Storage::disk('s3')->url($filename);

                    $data = [
                        'status' => 200,
                        'video_path' => $url,
                        'server' => config('app.name', 'AWS'),
                        'message' => 'successfully uploaded'
                    ];
                } else {
                    $data = [
                        'status' => 400,
                        'message' => 'could not be uploaded'
                    ];
                }
            } else {
                $filename = Storage::disk('videos')->put('', $request->video);
                $data = [
                    'status' => 200,
                    'video_path' => $request->root() . '/api/video/' . $filename,
                    'server' => config('app.name', 'Own'),
                    'message' => 'successfully uploaded'
                ];
            }
        } else {
            $data = [
                'status' => 400,
                'message' => 'could not be uploaded'
            ];
        }

        return response()->json($data, $data['status']);
    }

    // return an video from the videos disk of the storage
    public function show($filename)
    {

        $video = Storage::disk('videos')->get("$filename");

        $mime = Storage::disk('videos')->mimeType("$filename");

        return (new Response($video, 200))
            ->header('Content-Type', $mime);
    }
}
