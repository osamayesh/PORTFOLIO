<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSummaryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // For now, allow all users. You can add authentication later
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'category' => 'required|in:api,git,advanced,books,courses,documentation',
            'color_scheme' => 'required|in:blue,green,orange,purple',
            'published_date' => 'required|date',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ];

        // If this is a POST request (creating), PDF is required
        // If this is a PUT/PATCH request (updating), PDF is optional
        if ($this->isMethod('post')) {
            $rules['pdf_file'] = 'required|file|mimes:pdf|max:10240'; // 10MB max
        } else {
            $rules['pdf_file'] = 'nullable|file|mimes:pdf|max:10240';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title_en.required' => 'English title is required.',
            'title_ar.required' => 'Arabic title is required.',
            'description_en.required' => 'English description is required.',
            'description_ar.required' => 'Arabic description is required.',
            'category.required' => 'Category is required.',
            'category.in' => 'Selected category is invalid.',
            'color_scheme.required' => 'Color scheme is required.',
            'color_scheme.in' => 'Selected color scheme is invalid.',
            'published_date.required' => 'Published date is required.',
            'published_date.date' => 'Published date must be a valid date.',
            'pdf_file.required' => 'PDF file is required.',
            'pdf_file.mimes' => 'File must be a PDF.',
            'pdf_file.max' => 'PDF file size cannot exceed 10MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
            'sort_order' => $this->sort_order ?? 0,
        ]);
    }
}
