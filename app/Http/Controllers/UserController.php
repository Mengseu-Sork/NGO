<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Membership;
use App\Models\NewMembership;

class UserController extends Controller
{
    public function index()
    {
        $memberships = Membership::with('user', 'networks', 'focalPoints')
            ->where('membership_status', false) // Only show "No"
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.user', compact('memberships'));
    }

    public function profile()
    {
        $memberships = Membership::with('user', 'networks', 'focalPoints')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.profile', compact('memberships'));
    }

    public function newProfile()
    {
       $memberships = NewMembership::with([
            'user', 
            'membershipUploads.networks',
            'membershipUploads.focalPoints'
        ])
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('users.newProfile', compact('memberships'));
    }
}
