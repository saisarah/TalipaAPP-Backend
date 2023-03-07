<?php

namespace App\Http\Middleware;

use App\Models\FarmerGroupMember;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureFarmerIsPresident
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
        $user = Auth::user();
        $role = FarmerGroupMember::where('farmer_id', $user->id)->first();
        if ($role->isPresident()) {
            return $next($request);
        }
        
        return abort(403, "You don't have permission to access this resource.");
    }
}
