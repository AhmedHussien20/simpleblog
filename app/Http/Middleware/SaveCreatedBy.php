<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SaveCreatedBy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

    if ($user) {
        $models = ['App\Models\Post'];
        foreach ($models as $model) {
            if (Schema::hasColumn((new $model)->getTable(), 'created_by')) {
                $request->request->add(['created_by' => $user->id]);
            }
        }
    }
        $response = $next($request);

        // Check if the model being saved has the created_by attribute
        if ($response->status() === 201 && isset($response->original->created_by)) {
            $response->original->created_by = $request->created_by;
            $response->original->save();
        }

        return $response;
    }
}
