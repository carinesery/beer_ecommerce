<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAccountUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date', 'before:-18 years'],
            'email' => [
                'required', 
                'email', 
                'max:255', 
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'birthdate.before' => 'Vous devez avoir au moins 18 ans pour vous inscrire.',
            'email.unique' => 'Cet email est déjà utilisé, merci d’en choisir un autre.',
        ];
    }

    public function attributes()
    {
        return [
            'firstname' => 'prénom',
            'lastname' => 'nom',
            'birthdate' => 'date de naissance',
            'email' => 'adresse email',
        ];
    }
}
