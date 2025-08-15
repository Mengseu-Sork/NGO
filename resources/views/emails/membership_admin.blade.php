
<p>Dear Admin,</p>

<p>A new membership has been successfully confirmed. Please find the details below:</p>

<ul>
    <li><strong>Organization / NGO:</strong> {{ $membership->ngo_name ?? 'N/A' }}</li>
    <li><strong>Name:</strong> {{ $membership->director_name }}</li>
    <li><strong>Email:</strong> {{ $membership->director_email }}</li>
</ul>

<p>
    Please review the membership and take any necessary actions.  
    <a href="{{ route('admin.dashboard') }}">View Membership</a>
</p>

<p>Thank you,</p>
<p>NGOF Team</p>