<p>Dear {{ $membership->director_name }},</p>

<p>
    Thank you for completing Phase 2 of the NGOF membership confirmation process. We have successfully received your uploaded documents and information, which are now under review by our team.
</p>

<p>
    Please rest assured that your submission will remain strictly confidential and will be used solely for NGOF’s internal purposes. If our Membership Committee requires any additional details, we will contact you directly.
</p>

<p>
    You will soon receive an automated email providing you with access to your membership profile. 
</p>

<p>
    Please click the link below to access your membership profile:
    <a href="{{ $membershipProfileUrl }}" style="color: #1a73e8;">Access Your Membership Profile</a>
</p>

<p>
    If you have any questions or need assistance, please feel free to contact us at
    @foreach ($admins as $adminEmail)
        <a href="mailto:{{ $adminEmail }}">{{ $adminEmail }}</a>@if (!$loop->last), @endif
    @endforeach.
</p>

<p>
    We greatly appreciate your cooperation and look forward to our continued collaboration.
</p>

<p>
    Best regards,<br>
    NGOF Team<br>
    Led by CHAN Vicheth<br>
    Program Manager<br>
    NGO Forum on Cambodia
</p>
