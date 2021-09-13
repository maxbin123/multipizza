<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:7'],
            'address' => ['required', 'string'],
            'door' => ['numeric'],
            'floor' => ['numeric'],
            'flat' => ['numeric'],
            'code' => ['string'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'branch_id' => ['required', 'integer'],
            'items.*.product_id' => ['required', 'integer'],
            'items.*.quantity' => ['required', 'integer'],
            'items.*.ingredients.*' => ['integer']
        ];
    }
}
