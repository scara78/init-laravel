<?php

namespace App\Http\Controllers;

use App\Livetv;
use App\Embed;
use App\Http\Requests\LivetvRequest;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Jobs\SendNotification;

class LivetvController extends Controller
{
    // returns all livetv for api
    public function index()
    {
        return response()->json(Livetv::orderByDesc('id')->paginate(12), 200);
    }

    // returns all livetv for admin panel
    public function data()
    {
        return response()->json(Livetv::all(), 200);
    }
    
    // create a new livetv in the database
    public function store(LivetvRequest $request)
    {
        if(isset($request->livetv)){
            if (!filter_var($request->livetv['link'], FILTER_VALIDATE_URL)) { 
                $embed = new Embed();
                $embed->code = $request->livetv['link'];
                $embed->save();
                $request->livetv['link'] = $request->root() . '/api/embeds/show/' . $embed->id;
            }
            $livetv = New Livetv();
            $livetv->fill($request->livetv);
            $livetv->save();
            $data = [
                'status' => 200,
                'message' => 'successfully created',
                'body' => $livetv
            ];  
        }else{
            $data = [
                'status' => 400,
                'message' => 'could not be created',
            ];  
        }

        if($request->notification){
            $this->dispatch(new SendNotification($livetv));
        }
        
        return response()->json($data, $data['status']);
    }

    // returns a specific livetv
    public function show(Livetv $livetv)
    {
        return response()->json($livetv, 200);
    }

    // update a livetv in the database
    public function update(LivetvRequest $request, Livetv $livetv)
    {
        if($livetv != null){
            if (!filter_var($request->livetv['link'], FILTER_VALIDATE_URL)) { 
                $embed = new Embed();
                $embed->code = $request->livetv['link'];
                $embed->save();
                $request->livetv['link'] = $request->root() . '/api/embeds/show/' . $embed->id;
            }
            $livetv->fill($request->livetv);  
            $livetv->save();
            $data = [
                'status' => 200,
                'message' => 'successfully updated',
                'body' => $livetv
            ];  
        }else{
            $data = [
                'status' => 400,
                'message' => 'could not be updated',
            ];  
        }
        
        return response()->json($data, $data['status']);
    }

    // delete a livetv in the database
    public function destroy(Livetv $livetv)
    {
        if($livetv != null) {
            $livetv->delete();
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

    // save a new image in the livetv folder of the storage
    public function storeImg(StoreImageRequest $request) 
    {
        if ($request->hasFile('image')) {
            $filename = Storage::disk('livetv')->put('', $request->image);
            $data = [
                'status' => 200,
                'image_path' => $request->root().'/api/livetv/image/'.$filename,
                'message' => 'successfully uploaded'
            ];
        }else{
            $data = [
                'status' => 400,
            ];
        }

        return response()->json($data, $data['status']);
    }

    // return an image from the livetv folder of the storage
    public function getImg($filename) {

        $image = Storage::disk('livetv')->get($filename);

        $mime = Storage::disk('livetv')->mimeType($filename);

        return (new Response($image, 200))
              ->header('Content-Type', $mime);
    }
}
