<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCanceledMail extends Mailable
{
    use Queueable, SerializesModels;
    public $transaction;
    public $transactionDetails;

    /**
     * Create a new message instance.
     * @param $transaction
     * @param $transactionDetails

     */
    public function __construct($transaction, $transactionDetails)
    {
        $this->transaction = $transaction;
        $this->transactionDetails = $transactionDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Order Cancellation Notification")
            ->view("emails.order_canceled")
            ->with([
                "transaction" => $this->transaction,
                "transactionDetails" => $this->transactionDetails,
            ]);
    }

    public function envelope(): Envelope
    {
        $userName = $this->transaction->name; // Get the user's name
        $subject = "{$userName} Your Order With StorNex is Canceled"; // Set the subject with the user's name
        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: "emails.order_canceled",
            with: [
                "transaction" => $this->transaction,
                "transactionDetails" => $this->transactionDetails,
            ]
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
