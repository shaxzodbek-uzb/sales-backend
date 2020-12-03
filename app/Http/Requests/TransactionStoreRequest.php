<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Transaction;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => [
                'required',
                Rule::in(Transaction::TYPES),
            ],
            'products' => [
                'required',
                'array'
            ],
            'products.*.id' => [
                'required',
                'numeric',
                'exists:products,id',
            ],
            'products.*.quantity' => [
                'required',
                'numeric',
                'min:1',
            ],
            'products.*.price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'products.*.date' => [
                'date',
            ],
            "products.*.code" => [
                "numeric",
            ]
        ];
    }
}
