<x-mail::message>
# Registration Request Received

Hello,

A new registration request has been submitted for **{{ $event->title }}**.

**Registrant Details:**
- **Name:** {{ $registration->name ?? $registration->user->name }}
- **Email:** {{ $registration->email ?? $registration->user->email }}
- **Date:** {{ $event->date->format('M d, Y') }} at {{ $event->time->format('h:i A') }}

The registration is currently **pending approval** from the event organizer. Once approved, a digital ticket will be sent to the registrant's email.

<x-mail::button :url="route('events.show', $event)">
View Event Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
