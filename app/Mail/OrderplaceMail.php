<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderplaceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $user;
    public $cartItems;
    public $total;

    /**
     * Create a new message instance.
     *
     * @param $transaction
     * @param $user
     * @param $cartItems
     * @param $total
     */
    public function __construct($transaction, $user, $cartItems)
    {
        $this->transaction = $transaction;
        $this->user = $user;
        $this->cartItems = $cartItems;
        // $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("emails.OrderPlace")->subject(
            "Your Order Details"
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $userName = $this->user->name; // Get the user's name
        $subject = "StoreNex Order Confirmation for {$userName}"; // Set the subject with the user's name

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: "emails.OrderPlace",
            with: [
                "transactionId" => $this->transaction->id,
                "status" => $this->transaction->status,
                "cartItems" => $this->cartItems,
                "GrandTotal" => $this->transaction->total, // Ensure that total is correctly set here
                "userName" => $this->user->name,
                "invoiceDate" => $this->transaction->created_at->format(
                    "M d, Y"
                ),
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
