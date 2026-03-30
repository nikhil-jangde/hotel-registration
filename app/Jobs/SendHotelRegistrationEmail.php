<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class SendHotelRegistrationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $hotel;

    /**
     * Create a new job instance.
     */
    public function __construct($hotel)
    {
        $this->hotel = $hotel;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isMail(); // Send using PHP's mail() function

            // Recipients
            $mail->setFrom(config('mail.from.address', 'hello@example.com'), config('mail.from.name', 'Laravel'));
            $mail->addAddress($this->hotel['email'], $this->hotel['name']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Hotel Registration Successful';
            
            // Render Blade view
            $mail->Body = view('emails.hotel_registered', ['hotel' => $this->hotel])->render();
            $mail->AltBody = "Welcome, {$this->hotel['name']}! Your hotel has been successfully registered.";

            $mail->send();
            Log::info("Email sent to {$this->hotel['email']} using PHPMailer.");
        } catch (Exception $e) {
            Log::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            throw $e; // Rethrow to allow queue retry if configured
        }
    }
}
