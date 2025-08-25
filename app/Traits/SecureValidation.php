<?php

namespace App\Traits;

trait SecureValidation
{
    /**
     * Get secure validation rules for text input
     *
     * @param int $minLength
     * @param int $maxLength
     * @param bool $required
     * @param string $pattern Custom regex pattern (optional)
     * @return array
     */
    protected function getSecureTextRules(int $minLength = 3, int $maxLength = 255, bool $required = true, string $pattern = null): array
    {
        $rules = [];
        
        if ($required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }
        
        $rules[] = 'string';
        $rules[] = "min:{$minLength}";
        $rules[] = "max:{$maxLength}";
        
        // Default safe pattern if none provided
        if ($pattern) {
            $rules[] = "regex:{$pattern}";
        } else {
            $rules[] = 'regex:/^[\p{L}\p{N}\s\-_.,!?()]+$/u';
        }
        
        // XSS and SQL Injection protection
        $rules[] = 'not_regex:/(<script|javascript:|on\w+\s*=|<iframe|<object|<embed|eval\(|union\s+select|drop\s+table|delete\s+from|insert\s+into|update\s+set)/i';
        
        // Custom validation function
        $rules[] = function ($attribute, $value, $fail) {
            if (containsXSSPatterns($value)) {
                $fail(__('The :attribute contains potentially dangerous content.', ['attribute' => $attribute]));
            }
            if (containsSQLInjectionPatterns($value)) {
                $fail(__('The :attribute contains invalid characters.', ['attribute' => $attribute]));
            }
        };
        
        return $rules;
    }

    /**
     * Get secure validation rules for description/long text
     *
     * @param int $minLength
     * @param int $maxLength
     * @param bool $allowHTML
     * @return array
     */
    protected function getSecureDescriptionRules(int $minLength = 10, int $maxLength = 2000, bool $allowHTML = false): array
    {
        $rules = [
            'required',
            'string',
            "min:{$minLength}",
            "max:{$maxLength}",
        ];
        
        if (!$allowHTML) {
            // Block dangerous HTML patterns
            $rules[] = 'not_regex:/(<script|<\/script|javascript:|on\w+\s*=|<iframe|<object|<embed|eval\()/i';
        }
        
        // SQL Injection protection
        $rules[] = 'not_regex:/(union\s+select|drop\s+table|delete\s+from|insert\s+into|update\s+set|exec\s*\(|xp_cmdshell)/i';
        
        // Custom validation
        $rules[] = function ($attribute, $value, $fail) use ($allowHTML) {
            if (containsXSSPatterns($value)) {
                $fail(__('The :attribute contains potentially dangerous content.', ['attribute' => $attribute]));
            }
            if (containsSQLInjectionPatterns($value)) {
                $fail(__('The :attribute contains invalid characters.', ['attribute' => $attribute]));
            }
            if (!$allowHTML && containsExcessiveHTMLTags($value)) {
                $fail(__('The :attribute contains too many HTML-like tags.', ['attribute' => $attribute]));
            }
        };
        
        return $rules;
    }

    /**
     * Get secure validation rules for enum/select fields
     *
     * @param array $allowedValues
     * @param bool $required
     * @return array
     */
    protected function getSecureEnumRules(array $allowedValues, bool $required = true): array
    {
        $rules = [];
        
        if ($required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }
        
        $rules[] = 'string';
        $rules[] = 'max:100';
        
        // Only allow alphanumeric and underscore for enum values
        $rules[] = 'regex:/^[a-z_]+$/';
        
        // Whitelist validation
        $rules[] = function ($attribute, $value, $fail) use ($allowedValues) {
            if (!empty($value) && !in_array($value, $allowedValues, true)) {
                $fail(__('The selected :attribute is invalid.', ['attribute' => $attribute]));
            }
            
            // Additional security check
            if (containsXSSPatterns($value) || containsSQLInjectionPatterns($value)) {
                $fail(__('The :attribute contains invalid characters.', ['attribute' => $attribute]));
            }
        };
        
        return $rules;
    }

    /**
     * Get secure validation rules for location/address
     *
     * @param int $minLength
     * @param int $maxLength
     * @param bool $required
     * @return array
     */
    protected function getSecureLocationRules(int $minLength = 3, int $maxLength = 255, bool $required = true): array
    {
        $rules = [];
        
        if ($required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }
        
        $rules[] = 'string';
        $rules[] = "min:{$minLength}";
        $rules[] = "max:{$maxLength}";
        
        // Allow safe characters for addresses (including forward slash)
        $rules[] = 'regex:/^[\p{L}\p{N}\s\-_.,()\/]+$/u';
        
        // Security protection
        $rules[] = 'not_regex:/(<script|javascript:|on\w+\s*=|union\s+select|drop\s+table|delete\s+from|insert\s+into|update\s+set)/i';
        
        $rules[] = function ($attribute, $value, $fail) {
            if (!empty($value)) {
                if (containsXSSPatterns($value)) {
                    $fail(__('The :attribute contains potentially dangerous content.', ['attribute' => $attribute]));
                }
                if (containsSQLInjectionPatterns($value)) {
                    $fail(__('The :attribute contains invalid characters.', ['attribute' => $attribute]));
                }
            }
        };
        
        return $rules;
    }

    /**
     * Sanitize and validate input data
     *
     * @param array $data
     * @param array $rules
     * @return array ['valid' => bool, 'sanitized' => array, 'errors' => array]
     */
    protected function validateAndSanitizeData(array $data, array $rules): array
    {
        $sanitized = [];
        $errors = [];
        
        foreach ($data as $key => $value) {
            if (isset($rules[$key])) {
                // Sanitize the value
                $sanitized[$key] = sanitizeInput($value);
                
                // Additional validation can be added here
                if (!isSecureInput($value)) {
                    $errors[$key] = __('The :attribute contains potentially dangerous content.', ['attribute' => $key]);
                }
            } else {
                $sanitized[$key] = $value;
            }
        }
        
        return [
            'valid' => empty($errors),
            'sanitized' => $sanitized,
            'errors' => $errors
        ];
    }

    /**
     * Get custom security validation messages
     *
     * @return array
     */
    protected function getSecurityValidationMessages(): array
    {
        return [
            '*.regex' => __('The :attribute contains invalid characters.'),
            '*.not_regex' => __('The :attribute contains potentially dangerous content.'),
            '*.min' => __('The :attribute must be at least :min characters.'),
            '*.max' => __('The :attribute cannot exceed :max characters.'),
            '*.required' => __('The :attribute is required.'),
            '*.string' => __('The :attribute must be a string.'),
            '*.in' => __('The selected :attribute is invalid.'),
        ];
    }

    /**
     * Get security validation attributes
     *
     * @return array
     */
    protected function getSecurityValidationAttributes(): array
    {
        return [
            'name' => __('name'),
            'location' => __('location'),
            'description' => __('description'),
            'type' => __('type'),
            'category' => __('category'),
            'services_type' => __('service type'),
            'center' => __('location type'),
        ];
    }
}
