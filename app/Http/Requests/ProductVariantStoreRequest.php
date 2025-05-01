<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantStoreRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255'], 
            'volume' => ['required', 'string', 'max:50'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'price_without_tax' => ['required', 'numeric'],
            'tax_amount' => ['required', 'numeric', 'min:0', 'max:100'],
            'available' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'stock_quantity' => 'quantité en stock',
            'price_without_tax' => 'prix hors taxe',
            'tax_amount' => 'montant de la taxe',
            // 'available' => 'disponibilité'
        ];
    }
}
