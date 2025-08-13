<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipApplication;
use App\Models\Membership;
use Illuminate\Support\Facades\Storage;

class MembershipApplicationController extends Controller
{
    public function showForm()
    {
        return view('membership.formUpload');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'mailing-address' => 'nullable|string|max:255',
            'physical-address' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',

            'comm-channel' => 'nullable|array',
            'comm-channel.*' => 'in:Telegram,Signal,WhatsApp',

            'phone-telegram' => 'nullable|required_if:comm-channel,Telegram|string|max:20',
            'phone-signal' => 'nullable|required_if:comm-channel,Signal|string|max:20',
            'phone-whatsapp' => 'nullable|required_if:comm-channel,WhatsApp|string|max:20',

            'letter' => 'required|file',
            'constitution' => 'required|file',
            'activities' => 'required|file',
            'funding' => 'required|file',
            'registration' => 'required|file',
            'strategic-plan' => 'required|file',
            'fundraising-strategy' => 'nullable|file',
            'audit-report' => 'required|file',
            'signature' => 'required|file',

            'vision' => 'required|string',
            'mission' => 'required|string',
            'goal' => 'required|string',
            'objectives' => 'nullable|string',

            'director-name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $membership = Membership::firstOrCreate(
            ['user_id' => auth()->id()],
            ['membership_status' => 'pending'] // default or step-one values
        );

        // Handle file uploads and store paths
        $data = $request->all();

        $fileFields = [
            'letter', 'constitution', 'activities', 'funding',
            'registration', 'strategic-plan', 'fundraising-strategy',
            'audit-report', 'signature',
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('uploads/membership', 'public');
                $data[$field] = $path;
            }
        }

        // Communication channels and phones
        $commChannels = $request->input('comm-channel', []);
        $commPhones = [];
        foreach ($commChannels as $channel) {
            $phoneField = 'phone-' . strtolower($channel);
            if ($request->has($phoneField)) {
                $commPhones[$channel] = $request->input($phoneField);
            }
        }

        $application = MembershipApplication::create([
            'mailing_address' => $request->input('mailing-address'),
            'physical_address' => $request->input('physical-address'),
            'facebook' => $request->input('facebook'),
            'website' => $request->input('website'),

            'comm_channels' => $commChannels,
            'comm_phones' => $commPhones,

            'letter' => $data['letter'] ?? null,
            'constitution' => $data['constitution'] ?? null,
            'activities' => $data['activities'] ?? null,
            'funding' => $data['funding'] ?? null,
            'registration' => $data['registration'] ?? null,
            'strategic_plan' => $data['strategic-plan'] ?? null,
            'fundraising_strategy' => $data['fundraising-strategy'] ?? null,
            'audit_report' => $data['audit-report'] ?? null,
            'signature' => $data['signature'] ?? null,

            'vision' => $request->input('vision'),
            'mission' => $request->input('mission'),
            'goal' => $request->input('goal'),
            'objectives' => $request->input('objectives'),

            'director_name' => $request->input('director-name'),
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'membership_id' => $membership->id,
        ]);

        return redirect()->route('membership.thankyou')
            ->with('success', 'Membership application submitted successfully!');
    }
}
