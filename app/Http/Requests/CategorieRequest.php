<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieRequest extends FormRequest
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
		$id = $this->categorie ? ',' . $this->categorie->id : '';
        return [
			'nom' => 'required|string|max:255|unique:categories,nom' . $id,
            'description' => [
                'required', 'min:4'
            ],
        ];
    }
}
