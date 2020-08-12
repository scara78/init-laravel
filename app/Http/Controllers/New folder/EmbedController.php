<?php

namespace App\Http\Controllers;

use App\Embed;
use Illuminate\Http\Request;

class EmbedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Embed  $embed
     * @return \Illuminate\Http\Response
     */
    public function show(Embed $embed)
    {
    //    define('CHARSET', 'ISO-8859-1');
    //    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

    //   $embed = htmlspecialchars($embed->code, REPLACE_FLAGS, CHARSET);
      $embed = $embed->code;

        return view('embed', compact('embed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Embed  $embed
     * @return \Illuminate\Http\Response
     */
    public function edit(Embed $embed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Embed  $embed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Embed $embed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Embed  $embed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Embed $embed)
    {
        //
    }
}
