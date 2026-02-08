<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class BlockSuspiciousRequests
{
    /**
     * User agents commonly used by automated attack tools.
     */
    protected array $suspiciousUserAgents = [
        'python-requests',
        'python-urllib',
        'curl/',
        'wget/',
        'Go-http-client',
        'Java/',
        'libwww-perl',
        'Mechanize',
        'Scrapy',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        $userAgent = $request->userAgent() ?? '';

        // Protect Livewire endpoints from unauthenticated scripted access
        if ($this->isLivewireEndpoint($path) && $request->isMethod('POST')) {
            // Block known attack tool user agents on Livewire endpoints
            foreach ($this->suspiciousUserAgents as $agent) {
                if (stripos($userAgent, $agent) !== false) {
                    Log::channel('daily')->warning('Blocked suspicious Livewire request', [
                        'ip' => $request->ip(),
                        'user_agent' => $userAgent,
                        'path' => $path,
                    ]);
                    abort(403, 'Access denied.');
                }
            }

            // Rate limit Livewire POST requests: 60 per minute per IP
            $key = 'livewire-post:' . $request->ip();
            if (RateLimiter::tooManyAttempts($key, 60)) {
                Log::channel('daily')->warning('Rate limited Livewire request', [
                    'ip' => $request->ip(),
                    'path' => $path,
                ]);
                abort(429, 'Too many requests.');
            }
            RateLimiter::hit($key, 60);
        }

        // Block direct access to backdoor query parameters (detection/alerting)
        $suspiciousParams = ['wanna_play_with_me', 'cmd', 'exec', 'shell', 'c99', 'r57'];
        foreach ($suspiciousParams as $param) {
            if ($request->has($param)) {
                Log::channel('daily')->critical('ALERT: Backdoor access attempt detected', [
                    'ip' => $request->ip(),
                    'user_agent' => $userAgent,
                    'path' => $path,
                    'param' => $param,
                    'query' => $request->getQueryString(),
                ]);
                abort(403, 'Access denied.');
            }
        }

        return $next($request);
    }

    protected function isLivewireEndpoint(string $path): bool
    {
        return str_starts_with($path, 'livewire/') || $path === 'livewire';
    }
}
