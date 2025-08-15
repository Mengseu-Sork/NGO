@component('mail::message')
Dear Admin,

The following NGOs have **not completed Form (Pheas 2)** of their membership application within the required 15-day period:

@foreach ($overdueMemberships as $membership)
Name NGO: **{{ $membership->ngo_name }}**  
@endforeach

Please follow up with these organizations to ensure their applications are completed promptly.

Best regards,  
**NGO Forum on Cambodia**  
Membership Management System
@endcomponent
