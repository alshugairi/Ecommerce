<?php

namespace App\Http\Requests;

use Illuminate\{Foundation\Http\FormRequest};

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
            'description' => ['required', 'array'],
            'description.*' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = ['required', 'image', 'max:2048'];
        } elseif ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['image'] = ['nullable', 'image', 'max:2048'];
        }

        return $rules;
    }
}
