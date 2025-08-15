@component('mail::message')
# Dear {{ $user->name }},

We hope this message finds you well.

Our records indicate that you have **not yet completed Form (Phase 2)** of your membership application.  
Please complete it as soon as possible to avoid delays in processing your membership.

@component('mail::button', ['url' => route('membership.formUpload')])
Complete Form (Phase 2)
@endcomponent

Thank you for your attention to this matter.

Best regards,  
NGOF Team  
Led by CHAN Vicheth  
Program Manager  
NGO Forum on Cambodia
@endcomponent

