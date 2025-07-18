<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'erros' => $validator->errors(),
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required', Rule::unique('products'), 'string', 'min:5', 'max:255'],
            "description" => ['required', 'string', 'min:10', 'max:255'],
            "price" => ['required', 'numeric'],
            "quantity" => ['required', 'integer', 'between:1,9999'],
            "category_id" => ['required', 'exists:categories,id'],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.unique' => 'O nome já está em uso',
            'name.min' => 'O nome deve ter pelo menos 5 caracteres',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',
            'name.string' => 'O nome deve conter apenas letras',
            'description.required' => 'A descrição é obrigatória',
            'description.min' => 'A descrição deve ter pelo menos 10 caracteres',
            'description.max' => 'A descrição deve ter no máximo 255 caracteres',
            'description.string' => 'A descrição deve ser uma string',
            'price.required' => 'O preço é obrigatório',
            'price.numeric' => 'O preço deve ser um número',
            'quantity.required' => 'A quantidade é obrigatória',
            'quantity.integer' => 'A quantidade deve ser um número inteiro',
            'quantity.between' => 'A quantidade deve estar entre 1 e 9999',
            'category_id.required' => 'A categoria é obrigatória',
            'category_id.exists' => 'A categoria não existe',
            
        ];
    }
}
