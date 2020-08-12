<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogoRequest;
use App\Setting;
use App\Http\Requests\SettingsRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // return the settings by hiding the sensitive fields for the api
    public function index()
    {
        $settings = Setting::first()
            ->makeHidden([
                'authorization',
                'tmdb_api_key',
                'tmdb_lang',
                'aws_s3_storage',
                'aws_access_key_id',
                'aws_secret_access_key',
                'aws_default_region',
                'aws_bucket'
            ])->toArray();

        return response()->json($settings, 200);
    }

    // return all settings for the admin panel
    public function data()
    {
        return response()->json(Setting::first());
    }

    // update the settings in the database
    public function update(SettingsRequest $request, Setting $setting)
    {
        $setting->update($request->all());
        $data = [
            'status' => 200,
            'message' => 'successfully updated',
            'body' => $setting
        ];

        return response()->json($data, $data['status']);
    }

    // update the logo in the storage, deleting the folder and creating it again to ensure that there is only one file either PNG or SVG
    public function updateLogo(LogoRequest $request)
    {
        if ($request->hasFile('image')) {
            Storage::disk('public')->deleteDirectory('logo');
            $extension = $request->image->getClientOriginalExtension();
            $filename = Storage::disk('public')->putFileAs('logo', $request->image, "logo.$extension");
            $data = [
                'status' => 200,
                'image_path' => $request->root() . '/api/image/logo?' . time(),
            ];
        } else {
            $data = [
                'status' => 400,
            ];
        }

        return response()->json($data, $data['status']);
    }

    // return the logo checking the format
    public function showLogo()
    {
        if (Storage::disk('public')->exists('logo/logo.svg')) {
            $image = Storage::disk('public')->get('logo/logo.svg');
            $mime =  Storage::disk('public')->mimeType('/logo/logo.svg');
            $type = 'svg';
        } else {
            $image = Storage::disk('public')->get('logo/logo.png');
            $mime =  Storage::disk('public')->mimeType('logo/logo.png');
            $type = 'png';
        }
        return (new Response($image, 200))
            ->header('Content-Type', $mime)->header('type', $type);
    }

    // update the mini logo in the storage, deleting the folder and creating it again to ensure that there is only one file either PNG or SVG
    public function updateMiniLogo(LogoRequest $request)
    {
        if ($request->hasFile('image')) {
            Storage::disk('public')->deleteDirectory('miniLogo');
            $extension = $request->image->getClientOriginalExtension();
            $filename = Storage::disk('public')->putFileAs('miniLogo', $request->image, "miniLogo.$extension");
            $data = [
                'status' => 'success',
                'image_path' => $request->root() . '/api/image/minilogo?' . time(),
            ];
        } else {
            $data = [
                'status' => 'error',
            ];
        }

        return response()->json($data, 200);
    }

    // return the mini logo checking the format
    public function showMiniLogo()
    {
        if (Storage::disk('public')->exists('miniLogo/miniLogo.svg')) {
            $image = Storage::disk('public')->get('miniLogo/miniLogo.svg');
            $mime =  Storage::disk('public')->mimeType('/miniLogo/miniLogo.svg');
            $type = 'svg';
        } else {
            $image = Storage::disk('public')->get('miniLogo/miniLogo.png');
            $mime =  Storage::disk('public')->mimeType('miniLogo/miniLogo.png');
            $type = 'png';
        }
        return (new Response($image, 200))
            ->header('Content-Type', $mime)->header('type', $type);
    }

    // returns a null response with a status 200, to check the connection of the api.
    public function status()
    {
        return response()->json(null, 200);
    }
}
