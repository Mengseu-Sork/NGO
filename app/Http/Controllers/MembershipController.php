<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\MembershipNetwork;
use App\Models\MembershipFocalPoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    public function __construct()
    {
        // Require authentication for all methods except thankyou
        $this->middleware('auth')->except(['thankyou']);
    }
    
    public function showForm()
    {
        $userId = Auth::id();

        // Check if user already submitted form
        $existing = Membership::where('user_id', $userId)->first();

        if ($existing) {
            return redirect()->route('membership.thankyou');
        }

        return view('membership.form');
    }

    public function submitReconfirmation(Request $request)
    {

        if (Membership::where('user_id', Auth::id())->exists()) {
            return redirect()->route('membership.thankyou');
        }

        // Validate membership answer first
        $validator = Validator::make($request->all(), [
            'membership' => 'required|in:Yes,No',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If membership is "No", skip extra fields
        if ($request->membership === 'No') {
            Membership::create([
                'user_id' => Auth::id(),
                'membership_status' => false, // No
            ]);

            return redirect()->route('membership.thankyou');
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'ngo_name' => 'required_if:membership,Yes|string|max:255',
            'director_name' => 'required_if:membership,Yes|string|max:255',
            'director_phone' => 'required_if:membership,Yes|string|max:20',
            'director_email' => 'required_if:membership,Yes|email|max:255',
            'alt_name' => 'nullable|string|max:255',
            'alt_phone' => 'nullable|string|max:20',
            'alt_email' => 'nullable|email|max:255',
            'networks' => 'nullable|array',
            'networks.*' => 'in:NECCAW,BWG,RCC,NRLG,GGESI',
            'more_info' => 'required_if:membership,Yes|in:Yes,No',
            // Optional: add validation for focal points fields dynamically if needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $membership = Membership::create([
                'membership_status' => $request->membership === 'Yes',
                'ngo_name' => $request->ngo_name,
                'director_name' => $request->director_name,
                'director_phone' => $request->director_phone,
                'director_email' => $request->director_email,
                'alt_name' => $request->alt_name,
                'alt_phone' => $request->alt_phone,
                'alt_email' => $request->alt_email,
                'more_info' => $request->more_info === 'Yes',
                'user_id' => auth()->id(),
            ]);

            if ($request->has('networks')) {
                foreach ($request->networks as $network) {
                    $membership->networks()->create([
                        'network_name' => $network,
                    ]);

                    if ($request->filled("focal_name_{$network}")) {
                        MembershipFocalPoint::create([
                            'membership_id' => $membership->id,
                            'network_name' => $network,
                            'name' => $request->input("focal_name_{$network}"),
                            'sex' => $request->input("focal_sex_{$network}"),
                            'position' => $request->input("focal_position_{$network}"),
                            'email' => $request->input("focal_email_{$network}"),
                            'phone' => $request->input("focal_phone_{$network}"),
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('membership.thankyou')->with('success', 'Membership reconfirmation submitted successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Error submitting form: ' . $e->getMessage()])->withInput();
        }
    }

    public function thankyou()
    {
        return view('membership.thankyou');
    }
}
