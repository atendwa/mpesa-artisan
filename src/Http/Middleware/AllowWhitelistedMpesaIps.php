<?php

declare(strict_types=1);

namespace Atendwa\MpesaArtisan\Http\Middleware;

use Atendwa\MpesaArtisan\Core\IPWhitelist;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AllowWhitelistedMpesaIps
{
    /**
     * Handle an incoming request.
     *
     * This method checks if the incoming request's IP address is whitelisted.
     * If whitelisting is disabled or the IP is allowed, it passes the request.
     * Otherwise, it returns a 403 Unauthorized response.
     *
     * @param  Request  $request  The incoming HTTP request.
     * @param  Closure  $next  The next middleware to call.
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response|JsonResponse {
        $ipWhitelist = app(IPWhitelist::class);
        $allowed = $ipWhitelist->allows($request->ip() ?? '');

        return match (orCheck($ipWhitelist->disabled(), $allowed)) {
            false => $ipWhitelist->block(),
            true => $next($request),
        };
    }
}
