<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipUpload;
use Illuminate\Support\Facades\Auth;
use App\Models\newMembership;

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
        $totalNew = \App\Models\NewMembership::count();
        $totalOld = \App\Models\Membership::count();
        $totalRequest = 0;
        $totalCancel  = 0;
        $totalMembership = $totalOld + $totalNew;

        // Fake monthly data
        $months = ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $monthlyData = [50, 200, 300, 250, 500, 280, 400, 260, 520];

        return view('admin.dashboard', compact(
            'totalNew', 'totalOld', 'totalRequest', 'totalCancel',
            'months', 'monthlyData', 'totalMembership'
        ));
    }


    public function membershipShow()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $memberships = Membership::with('user', 'networks', 'focalPoints', 'applications')
            ->where('membership_status', true)  // Only show "Yes"
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.membership', compact('memberships'));
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

    public function newMembership()
    {
        $newMemberships = NewMembership::with([
            'user', 
            'membershipUploads.networks',
            'membershipUploads.focalPoints'
        ])->get();

        return view('admin.newMembership', compact('newMemberships'));
    }
}
