<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            // Règles pour la validation du produit
            'slug'=> ['required', 'string', 'unique:products'. $this->route('id')], // Ok ????
            'name'=> ['required', 'string', 'max:255'],
            'description'=> ['required', 'string'],
            'alcohol_degree' => ['required', 'numeric', 'min:0', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],

            // Validation de la marque
            'brand_id' => [
                'required_if:new_brand,null', // "brand_id" est requis si "new_brand" n'est pas renseigné
                'exists:brands,id',
                'nullable',
            ],
            'new_brand' => [
                'required_if:brand_id,null', // "new_brand" est requis si "brand_id" n'est pas renseigné
                'string',  // Vérifie que la marque est une chaîne de caractères
                'nullable',
                'max:255', // Longueur maximale de la marque
                'unique:brands,name', // Vérifie que le nom de la nouvelle marque n'est pas déjà existant
            ],
            'new_brand_description' => [
                'nullable', // Optionnel
                'string',
                'max:1000',
            ],
            'new_brand_logo' => [
                'nullable',
                'image', // Assurez-vous que c'est bien une image
                'mimes:jpeg,png,jpg,gif,svg', // Les formats d'images autorisés
                'max:2048', // Taille maximale de 2MB
            ],

            // Règles pour la validation des variantes
            'variants.*.slug' => ['required', 'string', 'unique:product_variants'. $this->route('id')], // Ok ????
            'variants.*.volume'=> ['required', 'string'], // Mettre un min et un max ?
            'variants.*.stock_quantity' => ['required', 'integer'],
            'variants.*.price_without_tax' => ['required', 'numeric'],
            'variants.*.tax_amount' => ['required', 'numeric'],
            'variants.*.available' => ['required', 'boolean'],
        ];
    }
}
