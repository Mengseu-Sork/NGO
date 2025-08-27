<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'ngo' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
        ]);

        User::create([
            'ngo' => $request->ngo,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if (Auth::user()->role === 'user') {
                $userInput = Auth::user()->ngo; // User can type either full name or abbreviation

                $ngoExists = \App\Models\Ngo::where('ngo_name', $userInput)
                    ->orWhere('abbreviation', $userInput)
                    ->exists();

                if (!$ngoExists) {
                    // If no matching NGO name found → redirect to membershipDetail page
                    return redirect()->route('membership.menbershipDetail');
                }

                // If NGO exists, continue with existing logic
                $hasMembership = \App\Models\Membership::where('user_id', Auth::id())->exists();

                $hasApp = \App\Models\MembershipApplication::whereHas('membership', function ($query) {
                    $query->where('user_id', Auth::id());
                })->exists();

                if ($hasApp && $hasMembership) {
                    return redirect()->route('profile');
                } elseif ($hasMembership) {
                    return redirect()->route('membership.formUpload');
                } else {
                    return redirect()->route('membership.form');
                }
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
