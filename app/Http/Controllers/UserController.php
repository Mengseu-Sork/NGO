<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('membership')->where('role', '!=', 'Admin')->get();

        return view('admin.user', compact('users'));
    }
}
