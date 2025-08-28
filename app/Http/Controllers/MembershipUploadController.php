<?php

namespace App\Http\Controllers;

use App\Models\MembershipUpload;
use Illuminate\Http\Request;
use App\Models\NewMembership;

class MembershipUploadController extends Controller
{
    public function form()
    {
        return view('membership.membershipUpload');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'networks' => 'nullable|array',
            'pledge_accept' => 'required',
            'letter' => 'nullable|file|mimes:pdf,doc,docx',
            'constitution' => 'nullable|file|mimes:pdf,doc,docx',
            'activities' => 'nullable|file|mimes:pdf,doc,docx',
            'funding' => 'nullable|file|mimes:pdf,doc,docx',
            'registration' => 'nullable|file|mimes:pdf,doc,docx',
            'strategic_plan' => 'nullable|file|mimes:pdf,doc,docx',
            'fundraising_strategy' => 'nullable|file|mimes:pdf,doc,docx',
            'audit_report' => 'nullable|file|mimes:pdf,doc,docx',
            'goal' => 'nullable|file|mimes:pdf,doc,docx',
            'signature' => 'nullable|string',
        ]);

        // Upload files
        foreach (['letter','constitution','activities','funding','registration',
                  'strategic_plan','fundraising_strategy','audit_report','goal'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $request->file($field)->store('memberships', 'public');
            }
        }

        // Save membership
        $latestMembership = NewMembership::latest()->first();
        $membership = MembershipUpload::create(array_merge($validated, [
            'new_membership_id' => $latestMembership->id ?? null, // fallback if none
        ]));

        // Save networks + focal points
        if ($request->has('networks')) {
            foreach ($request->networks as $network) {
                $membership->networks()->create(['network_name' => $network]);

                $membership->focalPoints()->create([
                    'network_name' => $network,
                    'name' => $request->input("focal_name_$network"),
                    'sex' => $request->input("focal_sex_$network"),
                    'position' => $request->input("focal_position_$network"),
                    'email' => $request->input("focal_email_$network"),
                    'phone' => $request->input("focal_phone_$network"),
                ]);
            }
        }

        return redirect()->route('membership.thankyou');
    }

}
