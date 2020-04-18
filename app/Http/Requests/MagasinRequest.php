<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagasinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => [
                'required', 'min:3'
            ],
            'localisation' => [
                'required', 'min:3'
            ],
			'slogan' => [
                'required', 'min:3'
            ],
			'adresse' => [
                'required', 'min:3'
            ],
        ];
    }
}
