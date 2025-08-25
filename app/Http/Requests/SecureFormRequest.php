<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\SecureValidation;

class SecureFormRequest extends FormRequest
{
    use SecureValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => $this->getSecureTextRules(3, 255, true),
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (containsXSSPatterns($value) || containsSQLInjectionPatterns($value)) {
                        $fail(__('The :attribute contains invalid characters.', ['attribute' => $attribute]));
                    }
                },
            ],
            'description' => $this->getSecureDescriptionRules(10, 1000, false),
            'location' => $this->getSecureLocationRules(3, 255, false),
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return array_merge(parent::messages(), $this->getSecurityValidationMessages());
    }

    /**
     * Get custom validation attributes
     */
    public function attributes(): array
    {
        return array_merge(parent::attributes(), $this->getSecurityValidationAttributes());
    }

    /**
     * Prepare the data for validation with sanitization
     */
    protected function prepareForValidation(): void
    {
        $sanitizedData = [];
        
        foreach ($this->all() as $key => $value) {
            if (is_string($value)) {
                $sanitizedData[$key] = sanitizeInput($value);
            } else {
                $sanitizedData[$key] = $value;
            }
        }
        
        $this->merge($sanitizedData);
    }

    /**
     * Handle a passed validation attempt with additional security checks
     */
    public function passedValidation(): void
    {
        // Additional security validation after Laravel validation passes
        foreach ($this->validated() as $key => $value) {
            if (is_string($value) && !isSecureInput($value)) {
                throw new \Illuminate\Validation\ValidationException(
                    validator([], []),
                    response()->json([
                        'message' => __('The given data contains potentially dangerous content.'),
                        'errors' => [$key => [__('The :attribute contains potentially dangerous content.', ['attribute' => $key])]]
                    ], 422)
                );
            }
        }
    }
}
