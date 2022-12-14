<?php

namespace App\Domain\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdIndexRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'sortBy' => ['nullable', Rule::in(['price', 'created_at'])],
            'descending' => ['nullable', 'boolean'],
            'rowPerPage' => ['nullable', 'integer', 'min:5'],
            'category' => ['nullable', 'string'],
        ];
    }
}
