<?php

namespace App\Http\Requests\Administration;

use Illuminate\{Foundation\Http\FormRequest};

class LanguageRequest extends FormRequest
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
        $languageId = $this->route('language');

        $rules['name'] = ['required', 'string', 'max:255', 'unique:languages,name,' . $languageId];
        $rules['code'] = ['required', 'string', 'max:255', 'unique:languages,code,' . $languageId];
        return $rules;
    }
}
