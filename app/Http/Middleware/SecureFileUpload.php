<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecureFileUpload
{
    /**
     * Dangerous file extensions that must never be uploaded.
     */
    protected array $blockedExtensions = [
        'php', 'php3', 'php4', 'php5', 'php7', 'php8',
        'phtml', 'phar', 'phps',
        'exe', 'sh', 'bat', 'cmd', 'com', 'cgi',
        'pl', 'py', 'rb', 'jsp', 'asp', 'aspx',
        'htaccess', 'htpasswd',
        'shtml', 'shtm',
    ];

    /**
     * Allowed MIME types whitelist for uploads.
     */
    protected array $allowedMimeTypes = [
        // Images
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/bmp',
        'image/svg+xml',
        // Documents
        'application/pdf',
        // Livewire temporary upload chunks
        'application/octet-stream',
    ];

    /**
     * PHP code signatures to scan for in uploaded file content.
     */
    protected array $phpSignatures = [
        '<?php',
        '<?=',
        '<? ',
        '<?\n',
        '<?\r',
        '<%',
        '<script language="php"',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasFile('*') && empty($request->allFiles())) {
            return $next($request);
        }

        foreach ($request->allFiles() as $key => $files) {
            $files = is_array($files) ? $files : [$files];

            foreach ($files as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                $originalName = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $mimeType = $file->getMimeType();

                // Layer 1: Block dangerous extensions
                if (in_array($extension, $this->blockedExtensions, true)) {
                    $this->logBlockedUpload($request, $originalName, "Blocked extension: .{$extension}");
                    abort(403, 'File type not allowed.');
                }

                // Layer 2: Check for double extensions (e.g., file.php.jpg)
                $nameParts = explode('.', $originalName);
                if (count($nameParts) > 2) {
                    foreach ($nameParts as $part) {
                        if (in_array(strtolower($part), $this->blockedExtensions, true)) {
                            $this->logBlockedUpload($request, $originalName, "Blocked double extension containing: .{$part}");
                            abort(403, 'File type not allowed.');
                        }
                    }
                }

                // Layer 3: Validate MIME type against whitelist
                if ($mimeType && !in_array($mimeType, $this->allowedMimeTypes, true)) {
                    $this->logBlockedUpload($request, $originalName, "Blocked MIME type: {$mimeType}");
                    abort(403, 'File type not allowed.');
                }

                // Determina se il file è un media binario (es. immagini o chunk Livewire)
                $isBinaryMedia = $mimeType && (str_starts_with($mimeType, 'image/') || $mimeType === 'application/octet-stream');

                // Layer 4: Scan file content for PHP code signatures
                // Salta la scansione sui media binari per evitare falsi positivi su contenuti compressi (PNG/JPEG/HEIC)
                if (!$isBinaryMedia && $file->getSize() < 5 * 1024 * 1024) { // Only scan files under 5MB
                    $content = file_get_contents($file->getRealPath());
                    if ($content !== false) {
                        $contentLower = strtolower($content);
                        foreach ($this->phpSignatures as $signature) {
                            if (str_contains($contentLower, strtolower($signature))) {
                                $this->logBlockedUpload($request, $originalName, "PHP code detected in file content");
                                abort(403, 'File contains prohibited content.');
                            }
                        }

                        // Check for common webshell patterns
                        if (preg_match('/\b(eval|assert|system|exec|passthru|shell_exec|popen|proc_open|pcntl_exec)\s*\(/i', $content)) {
                            $this->logBlockedUpload($request, $originalName, "Webshell pattern detected in file content");
                            abort(403, 'File contains prohibited content.');
                        }

                        if (preg_match('/\b(base64_decode|gzinflate|gzuncompress|str_rot13)\s*\(/i', $content)) {
                            $this->logBlockedUpload($request, $originalName, "Obfuscation pattern detected in file content");
                            abort(403, 'File contains prohibited content.');
                        }
                    }
                }

                // Log successful upload attempt
                Log::channel('daily')->info('File upload accepted', [
                    'ip' => $request->ip(),
                    'user' => $request->user()?->id,
                    'file' => $originalName,
                    'mime' => $mimeType,
                    'size' => $file->getSize(),
                    'uri' => $request->getRequestUri(),
                ]);
            }
        }

        return $next($request);
    }

    /**
     * Log a blocked upload attempt with full details.
     */
    protected function logBlockedUpload(Request $request, string $filename, string $reason): void
    {
        Log::channel('daily')->warning('BLOCKED file upload attempt', [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user' => $request->user()?->id,
            'file' => $filename,
            'reason' => $reason,
            'uri' => $request->getRequestUri(),
            'method' => $request->method(),
        ]);
    }
}
