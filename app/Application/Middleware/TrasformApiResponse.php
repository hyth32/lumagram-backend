<?php

namespace Application\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrasformApiResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $success = (bool) $response->isSuccessful();
        $error = null;
        $content = json_decode($response->getContent(), true);
        
        if (!$success) {
            $error = $content['message'] ?? $content['meta']['error'] ?? '';
            $content = $content['data'] ?? [];
        }

        $response->setContent(json_encode(
            $this->wrap($success, $content, $error)
        ));

        return $response;
    }

    public function wrap($success, $content, $error)
    {
        $wrapped = ['success' => $success];

        if ($error) {
            $wrapped['error'] = $error;
        } else {
            $wrapped['data'] = $content;
        }

        return $wrapped;
    }
}
