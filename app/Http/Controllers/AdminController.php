<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Ensure only admin can access these methods
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }
            abort(403, 'Unauthorized access.');
        });
    }

    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $memberships = Membership::with('user', 'networks', 'focalPoints', 'applications')
            ->where('membership_status', true)  // Only show "Yes"
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.dashboard', compact('memberships'));
    }

    public function show($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $membership = Membership::with('user', 'networks', 'focalPoints', 'applications')
            ->findOrFail($id);

        return view('admin.show', compact('membership'));
    }
}
