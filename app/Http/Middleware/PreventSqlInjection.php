<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventSqlInjection
{
    protected array $patterns = [
        '/(\b(SELECT|INSERT|UPDATE|DELETE|DROP|CREATE|ALTER|EXEC|UNION|FETCH|DECLARE|TRUNCATE)\b)/i',
        '/(--|;|\/\*|\*\/|xp_)/i',
        '/(\bOR\b\s+\b\d+\b\s*=\s*\b\d+\b)/i',
        '/(\bAND\b\s+\b\d+\b\s*=\s*\b\d+\b)/i',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->containsSqlInjection($request->all())) {
            abort(403, 'Solicitud detectada como potencialmente insegura.');
        }

        return $next($request);
    }

    protected function containsSqlInjection(array $data): bool
    {
        foreach ($data as $value) {
            if (is_string($value)) {
                foreach ($this->patterns as $pattern) {
                    if (preg_match($pattern, $value)) {
                        return true;
                    }
                }
            } elseif (is_array($value)) {
                if ($this->containsSqlInjection($value)) {
                    return true;
                }
            }
        }
        return false;
    }
}
