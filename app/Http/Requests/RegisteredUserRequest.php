<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisteredUserRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).+$/', 'confirmed'],
            'password_confirmation' => ['required'],
            'privacy_policy' => ['accepted']
        ];
    }

    public function messages(): array
    {
        return [
            'birthdate.before' => 'Vous devez avoir au moins 18 ans pour vous inscrire.',
            'email.unique' => 'Cet email est déjà utilisé, merci d’en choisir un autre.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password' => ['regex' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial parmi les caractères spéciaux !@#$%^&*()',],
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'privacy_policy.accepted' => 'Vous devez accepter la politique de confidentialité.',
        ];
    }

    public function attributes()
    {
        return [
            'firstname' => 'prénom',
            'lastname' => 'nom',
            'birthdate' => 'date de naissance',
            'email' => 'adresse email',
            'password' => 'mot de passe',
            'password_confirmation' => 'confirmation du mot de passe',
            'privacy_policy' => 'politique de confidentialité'
        ];
    }

    // Concernant les attributes, ils ont été ajoutés au fichier resources/lang/fr/validation.php pour une plus grande accessibilité.
}
