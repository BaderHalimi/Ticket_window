<?php

if (!function_exists('containsXSSPatterns')) {
    /**
     * Check for XSS patterns in input
     *
     * @param string|null $input
     * @return bool
     */
    function containsXSSPatterns($input): bool
    {
        if (empty($input)) {
            return false;
        }

        // Common XSS patterns
        $xssPatterns = [
            // Script tags
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi',
            '/javascript:/i',
            '/vbscript:/i',
            '/onload\s*=/i',
            '/onerror\s*=/i',
            '/onclick\s*=/i',
            '/onmouseover\s*=/i',
            '/onfocus\s*=/i',
            '/onblur\s*=/i',
            '/onchange\s*=/i',
            '/onsubmit\s*=/i',
            '/onkeyup\s*=/i',
            '/onkeydown\s*=/i',
            '/onmousedown\s*=/i',
            '/onmouseup\s*=/i',
            
            // HTML tags that can be dangerous
            '/<iframe\b/i',
            '/<object\b/i',
            '/<embed\b/i',
            '/<applet\b/i',
            '/<meta\b/i',
            '/<link\b/i',
            '/<style\b/i',
            '/<form\b/i',
            '/<input\b/i',
            '/<textarea\b/i',
            '/<button\b/i',
            
            // Data URLs
            '/data:\s*text\/html/i',
            '/data:\s*application\/javascript/i',
            '/data:\s*text\/javascript/i',
            
            // Expression and eval
            '/expression\s*\(/i',
            '/eval\s*\(/i',
            '/setTimeout\s*\(/i',
            '/setInterval\s*\(/i',
            '/Function\s*\(/i',
            
            // HTML entities that could be used for XSS
            '/&#x?[0-9a-f]+;?/i',
            
            // Base64 encoded scripts
            '/base64\s*,/i',
            
            // CSS expressions
            '/expression\s*\(/i',
            '/-moz-binding/i',
            
            // SVG XSS
            '/<svg\b/i',
            '/xmlns\s*=/i',
            
            // Additional dangerous patterns
            '/document\s*\./i',
            '/window\s*\./i',
            '/alert\s*\(/i',
            '/confirm\s*\(/i',
            '/prompt\s*\(/i',
        ];

        foreach ($xssPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('containsSQLInjectionPatterns')) {
    /**
     * Check for SQL Injection patterns in input
     *
     * @param string|null $input
     * @return bool
     */
    function containsSQLInjectionPatterns($input): bool
    {
        if (empty($input)) {
            return false;
        }

        // Common SQL injection patterns
        $sqlPatterns = [
            // SQL keywords
            '/\b(union\s+select)\b/i',
            '/\b(drop\s+table)\b/i',
            '/\b(delete\s+from)\b/i',
            '/\b(insert\s+into)\b/i',
            '/\b(update\s+set)\b/i',
            '/\b(create\s+table)\b/i',
            '/\b(alter\s+table)\b/i',
            '/\b(truncate\s+table)\b/i',
            '/\b(grant\s+select)\b/i',
            '/\b(revoke\s+select)\b/i',
            
            // SQL functions and procedures
            '/\b(exec\s*\()\b/i',
            '/\b(execute\s*\()\b/i',
            '/\b(xp_cmdshell)\b/i',
            '/\b(sp_executesql)\b/i',
            '/\b(openrowset)\b/i',
            '/\b(opendatasource)\b/i',
            
            // SQL comments
            '/--\s*$/m',
            '/\/\*.*?\*\//s',
            '/\#.*$/m',
            
            // SQL operators and characters
            '/;\s*(drop|delete|insert|update|create|alter|truncate)/i',
            '/\'\s*(or|and)\s*\'/i',
            '/\'\s*(or|and)\s*1\s*=\s*1/i',
            '/\'\s*or\s*\'.*?\'\s*=\s*\'/i',
            '/\'\s*;\s*(drop|delete|insert|update)/i',
            
            // Hex values that might be used in SQL injection
            '/0x[0-9a-f]+/i',
            
            // WAITFOR DELAY (SQL Server time-based injection)
            '/waitfor\s+delay/i',
            
            // BENCHMARK (MySQL time-based injection)
            '/benchmark\s*\(/i',
            
            // SLEEP (MySQL time-based injection)
            '/sleep\s*\(/i',
            
            // Information schema attacks
            '/information_schema/i',
            '/sys\./i',
            '/mysql\./i',
            
            // LOAD_FILE and INTO OUTFILE (MySQL)
            '/load_file\s*\(/i',
            '/into\s+outfile/i',
            '/into\s+dumpfile/i',
            
            // Blind SQL injection patterns
            '/\'\s*and\s*substring/i',
            '/\'\s*and\s*ascii/i',
            '/\'\s*and\s*length/i',
            
            // Boolean-based blind SQL injection
            '/\'\s*and\s*\d+\s*=\s*\d+/i',
            '/\'\s*or\s*\d+\s*=\s*\d+/i',
        ];

        foreach ($sqlPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('containsExcessiveHTMLTags')) {
    /**
     * Check for excessive HTML tags in input
     *
     * @param string|null $input
     * @param int $maxTags
     * @return bool
     */
    function containsExcessiveHTMLTags($input, int $maxTags = 10): bool
    {
        if (empty($input)) {
            return false;
        }

        // Count HTML-like tags
        $tagCount = preg_match_all('/<[^>]*>/', $input);
        
        // If more than specified tags, it might be suspicious
        if ($tagCount > $maxTags) {
            return true;
        }

        // Check for nested tags that could be used for XSS
        $nestedTagPatterns = [
            '/<[^>]*<[^>]*>/i',  // Tags within tags
            '/<[^>]*javascript:[^>]*>/i',  // JavaScript in tag attributes
            '/<[^>]*on\w+\s*=[^>]*>/i',  // Event handlers in tags
            '/<[^>]*data:[^>]*>/i',  // Data URLs in tags
            '/<[^>]*vbscript:[^>]*>/i',  // VBScript in tags
        ];

        foreach ($nestedTagPatterns as $pattern) {
            if (preg_match($pattern, $input)) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('sanitizeInput')) {
    /**
     * Sanitize input to prevent XSS and other attacks
     *
     * @param string|null $input
     * @param bool $allowHTML
     * @return string
     */
    function sanitizeInput($input, bool $allowHTML = false): string
    {
        if (empty($input)) {
            return '';
        }

        // Remove null bytes
        $input = str_replace(chr(0), '', $input);
        
        // Remove control characters except tab, newline, and carriage return
        $input = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $input);
        
        if (!$allowHTML) {
            // Remove or encode dangerous characters
            $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        } else {
            // If HTML is allowed, only remove dangerous tags
            $dangerousTags = [
                'script', 'iframe', 'object', 'embed', 'applet', 
                'meta', 'link', 'style', 'form', 'input', 
                'textarea', 'button', 'svg'
            ];
            
            foreach ($dangerousTags as $tag) {
                $input = preg_replace('/<' . $tag . '\b[^>]*>.*?<\/' . $tag . '>/is', '', $input);
                $input = preg_replace('/<' . $tag . '\b[^>]*\/?>/i', '', $input);
            }
            
            // Remove dangerous attributes
            $input = preg_replace('/\s*on\w+\s*=\s*["\'][^"\']*["\']/i', '', $input);
            $input = preg_replace('/\s*javascript:\s*[^"\'>\s]*/i', '', $input);
            $input = preg_replace('/\s*vbscript:\s*[^"\'>\s]*/i', '', $input);
        }
        
        // Remove any remaining script tags
        $input = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $input);
        
        return trim($input);
    }
}

if (!function_exists('isSecureInput')) {
    /**
     * Check if input is secure (no XSS, SQL injection, or excessive HTML)
     *
     * @param string|null $input
     * @param int $maxHTMLTags
     * @return bool
     */
    function isSecureInput($input, int $maxHTMLTags = 10): bool
    {
        if (empty($input)) {
            return true;
        }

        return !containsXSSPatterns($input) && 
               !containsSQLInjectionPatterns($input) && 
               !containsExcessiveHTMLTags($input, $maxHTMLTags);
    }
}

if (!function_exists('validateSecureString')) {
    /**
     * Validate string for security and return sanitized version
     *
     * @param string|null $input
     * @param int $minLength
     * @param int $maxLength
     * @param bool $allowHTML
     * @return array ['valid' => bool, 'sanitized' => string, 'errors' => array]
     */
    function validateSecureString($input, int $minLength = 1, int $maxLength = 255, bool $allowHTML = false): array
    {
        $errors = [];
        $sanitized = '';

        if (empty($input)) {
            if ($minLength > 0) {
                $errors[] = 'Input is required';
            }
            return ['valid' => empty($errors), 'sanitized' => $sanitized, 'errors' => $errors];
        }

        // Check length
        if (strlen($input) < $minLength) {
            $errors[] = "Input must be at least {$minLength} characters";
        }

        if (strlen($input) > $maxLength) {
            $errors[] = "Input cannot exceed {$maxLength} characters";
        }

        // Check for security threats
        if (containsXSSPatterns($input)) {
            $errors[] = 'Input contains potentially dangerous content (XSS)';
        }

        if (containsSQLInjectionPatterns($input)) {
            $errors[] = 'Input contains invalid characters (SQL Injection)';
        }

        if (!$allowHTML && containsExcessiveHTMLTags($input)) {
            $errors[] = 'Input contains too many HTML-like tags';
        }

        // Sanitize the input
        $sanitized = sanitizeInput($input, $allowHTML);

        return [
            'valid' => empty($errors),
            'sanitized' => $sanitized,
            'errors' => $errors
        ];
    }
}
