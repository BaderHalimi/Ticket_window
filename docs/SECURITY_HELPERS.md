# Security Helpers Documentation

## Overview
This document describes the security helper functions and classes available in the application to protect against XSS, SQL Injection, and other security threats.

## Global Security Functions

### 1. `containsXSSPatterns($input)`
Checks if input contains XSS (Cross-Site Scripting) patterns.

```php
if (containsXSSPatterns($userInput)) {
    // Handle dangerous input
    throw new ValidationException('Dangerous content detected');
}
```

**Detects:**
- Script tags: `<script>`, `</script>`
- JavaScript URLs: `javascript:`, `vbscript:`
- Event handlers: `onload`, `onclick`, `onmouseover`, etc.
- Dangerous HTML tags: `<iframe>`, `<object>`, `<embed>`
- Data URLs with scripts
- JavaScript functions: `eval()`, `setTimeout()`

### 2. `containsSQLInjectionPatterns($input)`
Checks if input contains SQL Injection patterns.

```php
if (containsSQLInjectionPatterns($userInput)) {
    // Handle SQL injection attempt
    Log::warning('SQL injection attempt detected');
}
```

**Detects:**
- SQL keywords: `UNION SELECT`, `DROP TABLE`, `DELETE FROM`
- SQL functions: `EXEC()`, `xp_cmdshell`
- SQL comments: `--`, `/* */`
- Boolean-based injections: `' OR '1'='1`
- Time-based injections: `WAITFOR DELAY`, `BENCHMARK()`

### 3. `containsExcessiveHTMLTags($input, $maxTags = 10)`
Checks if input contains excessive HTML tags.

```php
if (containsExcessiveHTMLTags($description, 5)) {
    // Too many HTML tags detected
    return 'Description contains too many HTML tags';
}
```

### 4. `sanitizeInput($input, $allowHTML = false)`
Sanitizes input to prevent XSS and other attacks.

```php
$cleanInput = sanitizeInput($userInput);
$cleanHTML = sanitizeInput($htmlContent, true); // Allow safe HTML
```

### 5. `isSecureInput($input, $maxHTMLTags = 10)`
Comprehensive security check for input.

```php
if (!isSecureInput($userInput)) {
    // Input failed security checks
    return 'Input contains dangerous content';
}
```

### 6. `validateSecureString($input, $minLength, $maxLength, $allowHTML)`
Validates and sanitizes string with detailed results.

```php
$result = validateSecureString($input, 3, 255, false);
if (!$result['valid']) {
    // Handle validation errors
    foreach ($result['errors'] as $error) {
        echo $error;
    }
} else {
    // Use sanitized input
    $cleanInput = $result['sanitized'];
}
```

## SecureValidation Trait

Use this trait in your classes for easy access to secure validation rules.

```php
use App\Traits\SecureValidation;

class MyController extends Controller
{
    use SecureValidation;
    
    public function store(Request $request)
    {
        $rules = [
            'name' => $this->getSecureTextRules(3, 255, true),
            'description' => $this->getSecureDescriptionRules(10, 1000),
            'category' => $this->getSecureEnumRules(['option1', 'option2']),
            'location' => $this->getSecureLocationRules(3, 255, false),
        ];
        
        $request->validate($rules);
    }
}
```

## SecureFormRequest Class

Extend this class for automatic security validation in form requests.

```php
use App\Http\Requests\SecureFormRequest;

class CreateServiceRequest extends SecureFormRequest
{
    public function rules(): array
    {
        return [
            'name' => $this->getSecureTextRules(3, 255),
            'description' => $this->getSecureDescriptionRules(10, 2000),
        ];
    }
}
```

## SecurityValidationMiddleware

Apply this middleware to routes that need extra security validation.

```php
// In routes/web.php
Route::middleware(['security.validation'])->group(function () {
    Route::post('/secure-endpoint', [Controller::class, 'method']);
});

// In app/Http/Kernel.php
protected $middlewareAliases = [
    'security.validation' => \App\Http\Middleware\SecurityValidationMiddleware::class,
];
```

## Usage Examples

### In Livewire Components

```php
use App\Traits\SecureValidation;

class MyLivewireComponent extends Component
{
    use SecureValidation;
    
    protected function rules()
    {
        return [
            'name' => $this->getSecureTextRules(3, 255),
            'description' => $this->getSecureDescriptionRules(10, 1000),
        ];
    }
    
    public function updated($field)
    {
        // Sanitize input
        $this->{$field} = sanitizeInput($this->{$field});
        
        // Validate
        $this->validateOnly($field);
    }
}
```

### In Controllers

```php
public function store(Request $request)
{
    // Manual validation
    foreach ($request->all() as $key => $value) {
        if (is_string($value) && !isSecureInput($value)) {
            return response()->json([
                'error' => "Field {$key} contains dangerous content"
            ], 422);
        }
    }
    
    // Or use validation rules
    $request->validate([
        'name' => [
            'required',
            'string',
            'min:3',
            'max:255',
            function ($attribute, $value, $fail) {
                if (containsXSSPatterns($value)) {
                    $fail('Dangerous content detected');
                }
            }
        ]
    ]);
}
```

## Security Best Practices

1. **Always sanitize user input** before storing in database
2. **Use whitelist validation** for enum/select fields
3. **Apply length limits** to prevent buffer overflow
4. **Log security threats** for monitoring
5. **Use HTTPS** for all sensitive data transmission
6. **Validate on both client and server side**
7. **Escape output** when displaying user content

## Configuration

The security functions are automatically loaded via `SecurityHelperServiceProvider`. Make sure it's registered in `config/app.php`:

```php
'providers' => [
    // ...
    App\Providers\SecurityHelperServiceProvider::class,
],
```

## Testing

Test your security implementations:

```php
// Test XSS protection
$xssInput = '<script>alert("xss")</script>';
$this->assertTrue(containsXSSPatterns($xssInput));

// Test SQL injection protection
$sqlInput = "'; DROP TABLE users; --";
$this->assertTrue(containsSQLInjectionPatterns($sqlInput));

// Test sanitization
$dirtyInput = '<script>alert("test")</script>Hello';
$cleanInput = sanitizeInput($dirtyInput);
$this->assertStringNotContainsString('<script>', $cleanInput);
```
