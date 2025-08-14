<p>Dear {{ $membership->director_name }},</p>

<p>
    Thank you for confirming your continued membership with NGOF.
    We’re pleased to let you know that you have successfully completed <strong>Phase 1</strong> of the confirmation process.
    Your information will remain confidential and will be used solely for NGOF purposes.
</p>

<p>
    To help us update our records and membership database, please complete the next form by
    <strong>{{ $deadline->format('F j, Y') }}</strong> (within 15 days).
</p>

<p>
    Please continue to Phase 2 using this link:
    <a href="{{ $nextFormUrl }}" style="color: #1a73e8;">Click here to continue to the next form</a>
</p>

<p>
    <strong>IMPORTANT NOTE:</strong>
    If you have any questions or need assistance, please contact us at
    @foreach ($admins as $adminEmail)
        <a href="mailto:{{ $adminEmail }}">{{ $adminEmail }}</a>@if (!$loop->last), @endif
    @endforeach
    or via Telegram at <strong> +855 12 953 650 </strong>.
</p>

<p>
    We appreciate your prompt attention to this matter and thank you for your continued collaboration.
</p>

<p>
    Best regards,<br>
    NGOF Team<br>
    Led by CHAN Vicheth<br>
    Program Manager<br>
    NGO Forum on Cambodia
</p>
