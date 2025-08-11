<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Membership;

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
}
