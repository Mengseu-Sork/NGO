<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\Form2ReminderMail;
use App\Mail\AdminOverdueListMail;

class SendForm2Reminder extends Command
{
    protected $signature = 'reminder:form2';
    protected $description = 'Send reminder to users and notify admins if Form 2 is incomplete after 15 days';

    public function handle()
    {
        $cutoffDate = Carbon::now()->subDays(15);

        $overdueMemberships = Membership::where('status', 'pending')
            ->whereDate('created_at', '<=', $cutoffDate)
            ->with('user') // Make sure Membership model has user() relationship
            ->get();

        if ($overdueMemberships->isEmpty()) {
            $this->info('No overdue memberships found.');
            return;
        }

        // Send reminder to each user with link
        foreach ($overdueMemberships as $membership) {
            $formLink = route('membership.formUpload', $membership->id); // Your route for Form 2

            Mail::to($membership->user->email)
                ->send(new Form2ReminderMail($membership->user, $formLink));
        }

        // Send list to all admins
        $admins = User::where('role', 'admin')->pluck('email')->toArray();
        Mail::to($admins)->send(new AdminOverdueListMail($overdueMemberships));

        $this->info('Reminders sent successfully.');
    }
}
