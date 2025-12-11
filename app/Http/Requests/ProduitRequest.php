<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
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
		$id = $this->produit ? ',' . $this->produit->id : '';
        return [
			'reference' => 'required|string|max:255|unique:produits,reference' . $id,
			'nom' => 'required|string|max:255|unique:produits,nom' . $id,
            'description' => [
                'required', 'min:4'
            ],
            'prix' => [
                'required', 'min:0'
            ],
            'prix_achat' => [
                'required', 'min:0'
            ],
        ];
    }
}
