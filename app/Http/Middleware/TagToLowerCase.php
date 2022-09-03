<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagToLowerCase
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tags = $request->input('tags');
        if ($tags && is_array($tags)) {
            foreach ($tags as $key => $tag) {
                $tags[$key] = strtolower($tag);
            }
            $request->request->set('tags', $tags);
        }
        return $next($request);
    }
}
