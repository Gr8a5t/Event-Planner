<x-mail::message>
# You're Going to {{ $event->title }}!

Hello {{ $registration->name ?? $registration->user->name }},

Your registration has been **approved**! We're excited to have you join us. This email serves as your official digital ticket.

---

### **🎟️ Event Ticket**
**Event:** {{ $event->title }}  
**Date:** {{ $event->date->format('l, F d, Y') }}  
**Time:** {{ $event->time->format('h:i A') }}  
**Location:** {{ $event->location }}

---

**Next Steps:**
- Add this event to your calendar.
- Show this email at the entrance.
- If it's an online event, the link will be provided separately or via the event page.

<x-mail::button :url="route('events.show', $event)">
View Event Page
</x-mail::button>

See you there!

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
