<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Mail\HotelRegistrationMail;
use App\Models\Hotel;
use Illuminate\Support\Facades\Mail;

class SendHotelRegistrationEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $toEmail, public Hotel $hotel)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->toEmail)->send(new HotelRegistrationMail($this->hotel));
    }
}
