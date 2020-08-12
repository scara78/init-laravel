<?php

namespace App\Http\Controllers;

use App\Server;
use App\Http\Requests\ServerRequest;

class ServerController extends Controller
{
    // create a new server in the database
    public function store(ServerRequest $request)
    {
        $server = New Server();
        $server->fill($request->all());
        $server->save();

        $data = [
            'status' => 200,
            'message' => 'successfully created',
            'body' => $server
        ];
        
        return response()->json($data, $data['status']);
    }

    // returns all server for admin panel
    public function data()
    {
        return response()->json(Server::all(), 200);
    }

   // update a server from database
    public function update(ServerRequest $request, Server $server)
    {
        $server->fill($request->all());
        $server->save();
        $data = [
            'status' => 200,
            'message' => 'successfully updated',
            'body' => $server
        ];

        return response()->json($data, $data['status']);
    }

    // delete a server from database
    public function destroy(Server $server)
    {
        if($server != null){
            $server->delete();
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
}
