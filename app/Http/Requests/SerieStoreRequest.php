<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SerieStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'serie.tmdb_id'       => 'integer|unique:series,tmdb_id',
            'serie.name'          => 'required',
            'serie.poster_path'   => 'nullable|URL',
            'serie.backdrop_path' => 'nullable|URL',
            'serie.preview_path'  => 'nullable|URL',
            'serie.vote_average'  => 'nullable|numeric',
            'serie.vote_count'    => 'nullable|numeric',
            'serie.popularity'    => 'nullable|numeric',
            'serie.release_date'  => 'nullable|date',
        ];
    }

public function messages()
{
    return [
        'serie.tmdb_id.integer' => 'the tmdb_id must be an integer.',
        'serie.tmdb_id.unique' => 'the tmdb_id is already exists in the database.',
        'serie.name.required' => 'the name is required.',
        'serie.poster_path.u_r_l' => 'the poster_path must be a URL',
        'serie.backdrop_path.u_r_l' => 'the backdrop_path must be a URL',
        'serie.preview_path.u_r_l' => 'the preview_path must be a URL',
        'serie.vote_average.numeric' => 'the vote_average must be a number',
        'serie.vote_count.numeric' => 'the vote_count must be a number',
        'serie.popularity.numeric' => 'the popularity must be a number',
        'serie.release_date.numeric' => 'the release_date must be a date',
    ];
}
}
