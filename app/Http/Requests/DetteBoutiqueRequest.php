<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetteBoutiqueRequest extends FormRequest
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
            'montant' => [
                'required', 'min:1'
            ],
            'description' => [
                'required', 'min:1'
            ],
            'partenaire' => [
                'required', 'min:1'
            ]
        ];
    }
}
