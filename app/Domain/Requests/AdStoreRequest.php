<?php

namespace App\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdStoreRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => ['prohibited'],
            'name' => ['required', 'string', 'min:5', 'max:200'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category' => ['required', 'string'],
            'photo' => ['array', 'max:3'],
            'photo.*.url' => ['url', 'distinct:strict'],
            'price' => ['required', 'numeric'],
        ];
    }
}
