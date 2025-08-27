<?php

namespace App\Http\Controllers;

use App\Models\NewMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewMembershipController extends Controller
{
    public function form() {
        return view('membership.membershipForm');
    }

    public function storeForm(Request $request) {
        $request->validate([
            'org_name_en' => 'required|string|max:255',
            'org_name_kh' => 'required|string|max:255',
            'membership_type' => 'required',
            'director_name' => 'required|string|max:255',
            'director_email' => 'required|email',
            'director_phone' => 'required|string|max:20',
            'representative_name' => 'required|string|max:255',
            'representative_email' => 'required|email',
            'representative_phone' => 'required|string|max:20',
            'representative_position' => 'required|string|max:100',


        ]);

        NewMembership::create(array_merge(
            $request->all(),
            ['user_id' => Auth::id()]  // ← add this
        ));
        return redirect()->route('membership.membershipUpload');
    }
}
