<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
            'authorization' => 'nullable|string',
            'tmdb_api_key' => 'nullable|string',
            'tmdb_lang' => 'required|array',
            'app_name' => 'required|string',
            'app_url_android' => 'nullable|URL',
            'app_url_ios' => 'nullable|URL',
            'title_in_poster' => 'required|boolean',
            'app_bar_animation' => 'required|boolean',
            'livetv' => 'required|boolean',
            'kids' => 'required|boolean',
            'ad_app_id' => 'required|string',
            'ad_banner' => 'required|boolean',
            'ad_unit_id_banner' => 'nullable|string',
            'ad_interstitial' => 'required|boolean',
            'ad_unit_id_interstitial' => 'nullable|string',
            'ad_ios_app_id' => 'required|string',
            'ad_ios_banner' => 'required|boolean',
            'ad_ios_unit_id_banner' => 'nullable|string',
            'ad_ios_interstitial' => 'required|boolean',
            'ad_ios_unit_id_interstitial' => 'nullable|string',
            'app_color_dark' => 'required|boolean',
            'app_background_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'app_header_recent_task_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'app_primary_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'app_splash_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'app_buttons_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'app_bar_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'app_bar_opacity' => 'required|numeric|max:1',
            'app_bar_icons_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'bottom_navigation_bar_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'icons_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'text_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'app_bar_title_color' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/']
        ];
    }

    public function messages()
    {
        return [
            'authorization.string' => ':attribute must be string',
            'tmdb_api_key.string' => ':attribute must be string',
            'tmdb_lang.required' => ':attribute is required',
            'tmdb_lang.array' => ':attribute must be array',
            'app_name.string' => ':attribute must be string',
            'app_url_android.u_r_l' => ':attribute must be URL',
            'app_url_ios.u_r_l' => ':attribute must be URL',
            'title_in_poster.boolean' => ':attribute must be boolean',
            'app_bar_animation.boolean' => ':attribute must be boolean',
            'livetv.boolean' => ':attribute must be boolean',
            'kids.boolean' => ':attribute must be boolean',
            'ad_app_id.string' => ':attribute must be string',
            'ad_banner.boolean' => ':attribute must be boolean',
            'ad_unit_id_banner.string' => ':attribute must be string',
            'ad_interstitial.boolean' => ':attribute must be boolean',
            'ad_unit_id_interstitial.string' => ':attribute must be string',
            'ad_ios_app_id.string' => ':attribute must be string',
            'ad_ios_banner.string' => ':attribute must be string',
            'ad_ios_unit_id_banner.string' => ':attribute must be string',
            'ad_ios_interstitial.string' => ':attribute must be string',
            'ad_ios_unit_id_interstitial.string' => ':attribute must be string',
            'app_color_dark.boolean' => ':attribute must be boolean',
            'app_background_color.regex' => ':attribute must be hex color',
            'app_header_recent_task_color.regex' => ':attribute must be hex color',
            'app_primary_color.regex' => ':attribute must be hex color',
            'app_splash_color.regex' => ':attribute must be hex color',
            'app_buttons_color.regex' => ':attribute must be hex color',
            'app_bar_color.regex' => ':attribute must be hex color',
            'app_bar_opacity.numeric' => ':attribute must be numeric',
            'app_bar_icons_color.regex' => ':attribute must be hex color',
            'bottom_navigation_bar_color.regex' => ':attribute must be hex color',
            'icons_color.regex' => ':attribute must be hex color',
            'text_color.regex' => ':attribute must be hex color',
            'app_bar_title_color.regex' => ':attribute must be hex color'
        ];
    }
}
