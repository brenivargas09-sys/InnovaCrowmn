<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH')) {
            $input = $request->all();
            $sanitized = $this->sanitize($input);
            $request->merge($sanitized);
        }

        return $next($request);
    }

    protected function sanitize(array $data): array
    {
        foreach ($data as $key => &$value) {
            if (is_string($value)) {
                $value = trim($value);
                $value = strip_tags($value);
                $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            } elseif (is_array($value)) {
                $value = $this->sanitize($value);
            }
        }
        unset($value);
        return $data;
    }
}
