<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user');
        return [
           "name" => ['required', 'string', 'min:5', 'max:255'],
           "email" => ['required', 'email', 'lowercase', Rule::unique('users')->ignore($userId->id)],
           "password" => ['required',Password::min(5)->max(15)->numbers()->symbols()->mixedCase()],
           //"file" => ['required', File::image()->min('1kb')->max('10mb')],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.min' => 'O nome deve ter pelo menos 5 caracteres',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',
            'name.string' => 'O nome deve ser uma string',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Email inválido',
            'email.unique' => 'Email já cadastrado',
            'email.lowercase' => 'Email deve ser em minúsculo',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos 5 caracteres',
            'password.max' => 'A senha deve ter no máximo 15 caracteres',
            'password.numbers' => 'A senha deve conter pelo menos um número',
            'password.symbols' => 'A senha deve conter pelo menos um símbolo',
            'password.mixedCase' => 'A senha deve conter pelo menos uma letra maiúscula e uma letra minúscula',
            
        ];
    }
}
