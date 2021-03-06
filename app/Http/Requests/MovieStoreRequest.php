<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieStoreRequest extends FormRequest
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
            'movie.tmdb_id'       => 'integer|unique:movies,tmdb_id',
            'movie.title'         => 'required',
            'movie.poster_path'   => 'nullable|URL',
            'movie.backdrop_path' => 'nullable|URL',
            'movie.preview_path'  => 'nullable|URL',
            'movie.vote_average'  => 'nullable|numeric',
            'movie.vote_count'    => 'nullable|numeric',
            'movie.popularity'    => 'nullable|numeric',
            'movie.release_date'  => 'nullable|date',
        ];
    }

public function messages()
{
    return [
        'movie.tmdb_id.integer' => 'the tmdb_id must be an integer.',
        'movie.tmdb_id.unique' => 'the tmdb_id is already exists in the database.',
        'movie.title.required' => 'the title is required.',
        'movie.poster_path.u_r_l' => 'the poster_path must be a URL',
        'movie.backdrop_path.u_r_l' => 'the backdrop_path must be a URL',
        'movie.preview_path.u_r_l' => 'the preview_path must be a URL',
        'movie.vote_average.numeric' => 'the vote_average must be a number',
        'movie.vote_count.numeric' => 'the vote_count must be a number',
        'movie.popularity.numeric' => 'the popularity must be a number',
        'movie.release_date.numeric' => 'the release_date must be a date',
    ];
}
}
