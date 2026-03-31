<x-mail::message>
# Hotel Registration Received!

Dear **{{ $hotel->name }}** Partner,

Your hotel registration is currently being processed with us. We are reviewing the details you've provided to ensure everything is correct for your dashboard setup.

### Registration Record
Below is a summary of the information saved in our records:

<x-mail::panel>
### 🏨 Hotel Details
- **Name:** {{ $hotel->name }}
- **Address:** {{ $hotel->address ?? 'N/A' }}
- **City & Postal:** {{ $hotel->city ?? 'N/A' }}, {{ $hotel->postalCode ?? 'N/A' }}
- **Country:** {{ $hotel->country ?? 'N/A' }}
- **Phone:** {{ $hotel->phone ?? 'N/A' }}
- **Website:** {{ $hotel->website ?? 'N/A' }}

### ⚙️ Property Info
- **Star Rating:** {{ $hotel->starRating ?? 'N/A' }} ⭐
- **Total Rooms:** {{ $hotel->totalRooms ?? 'N/A' }}
</x-mail::panel>

<x-mail::button :url="'http://localhost'">
Check Status
</x-mail::button>

Please review these details. If anything is incorrect, please contact our support team immediately.

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
