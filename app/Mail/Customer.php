<?php

namespace App\Mail;

use App\Enums\Status;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Customer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(private $mailData = [])
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = '';
        if($this->mailData['status'] == Status::CUSTOMER_CREATED) {
            $subject = 'Account created successfully';
        } elseif(in_array($this->mailData['status'], [Status::PROFILE_UPDATED, Status::CUSTOMER_UPDATED])) {
            $subject = 'Profile updated successfully';
        } elseif($this->mailData['status'] == Status::PASSWORD_UPDATED) {
            $subject = 'Password updated successfully';
        }
        return new Envelope(
            subject: $subject,
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'admin.client.customerEmail',
            with: ['data' => $this->mailData]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
