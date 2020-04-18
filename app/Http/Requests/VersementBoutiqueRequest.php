<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VersementBoutiqueRequest extends FormRequest
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
            'destination' => [
                'required', 'min:3'
            ],
            'montant' => [
                'required', 'min:1'
            ],
            'description' => [
                'required', 'min:3'
            ]
        ];
    }
}
