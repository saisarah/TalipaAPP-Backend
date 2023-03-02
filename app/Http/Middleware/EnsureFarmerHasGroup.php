<?php

namespace App\Http\Middleware;

use App\Models\FarmerGroupMember;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureFarmerHasGroup
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
        $id = Auth::id();
        $has_group = FarmerGroupMember::where('farmer_id', $id)->first();
        if ($has_group && $has_group->isApproved()) {
            return $next($request);
        }

        return abort(403, "You don't have permission to access this resource.");
    }
}
