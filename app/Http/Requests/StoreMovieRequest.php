<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:movies',
            'caption' => 'required',
            'image_url' => 'url',
            'rating' => 'required|between:1.0,10.0',
            'vote_count' => 'numeric',
            'released_at' => 'required|date_format:Y-m-d'
        ];
    }
}
