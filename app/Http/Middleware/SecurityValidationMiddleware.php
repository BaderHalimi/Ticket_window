<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityValidationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check all input data for security threats
        $this->validateRequestSecurity($request);

        return $next($request);
    }

    /**
     * Validate request for security threats
     */
    protected function validateRequestSecurity(Request $request): void
    {
        $dangerousInputs = [];

        // Check all input data
        foreach ($request->all() as $key => $value) {
            if (is_string($value)) {
                if (containsXSSPatterns($value)) {
                    $dangerousInputs[$key] = 'XSS patterns detected';
                } elseif (containsSQLInjectionPatterns($value)) {
                    $dangerousInputs[$key] = 'SQL injection patterns detected';
                } elseif (containsExcessiveHTMLTags($value)) {
                    $dangerousInputs[$key] = 'Excessive HTML tags detected';
                }
            } elseif (is_array($value)) {
                $this->validateArrayInput($key, $value, $dangerousInputs);
            }
        }

        // If dangerous content is found, log and reject
        if (!empty($dangerousInputs)) {
            $this->logSecurityThreat($request, $dangerousInputs);
            $this->rejectDangerousRequest($dangerousInputs);
        }
    }

    /**
     * Validate array input recursively
     */
    protected function validateArrayInput(string $parentKey, array $data, array &$dangerousInputs): void
    {
        foreach ($data as $key => $value) {
            $fullKey = $parentKey . '.' . $key;
            
            if (is_string($value)) {
                if (containsXSSPatterns($value)) {
                    $dangerousInputs[$fullKey] = 'XSS patterns detected';
                } elseif (containsSQLInjectionPatterns($value)) {
                    $dangerousInputs[$fullKey] = 'SQL injection patterns detected';
                } elseif (containsExcessiveHTMLTags($value)) {
                    $dangerousInputs[$fullKey] = 'Excessive HTML tags detected';
                }
            } elseif (is_array($value)) {
                $this->validateArrayInput($fullKey, $value, $dangerousInputs);
            }
        }
    }

    /**
     * Log security threat
     */
    protected function logSecurityThreat(Request $request, array $dangerousInputs): void
    {
        \Log::warning('Security threat detected in request', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'dangerous_inputs' => $dangerousInputs,
            'user_id' => auth()->id(),
            'timestamp' => now(),
        ]);
    }

    /**
     * Reject dangerous request
     */
    protected function rejectDangerousRequest(array $dangerousInputs): void
    {
        $errors = [];
        foreach ($dangerousInputs as $field => $threat) {
            $errors[$field] = [__('The :attribute contains potentially dangerous content.', ['attribute' => $field])];
        }

        abort(response()->json([
            'message' => __('The request contains potentially dangerous content and has been rejected.'),
            'errors' => $errors
        ], 422));
    }
}
