<?php

namespace App\Mail;

use App\Models\Bug;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BugStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $bug;
    public $oldStatus;

    // Menangkap data bug dan status lamanya
    public function __construct(Bug $bug, $oldStatus)
    {
        $this->bug = $bug;
        $this->oldStatus = $oldStatus;
    }

    // Mengatur Subjek Email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notifikasi Update Bug: ' . $this->bug->title,
        );
    }

    // Menunjuk ke file tampilan (HTML) email
    public function content(): Content
    {
        return new Content(
            view: 'emails.bug_status',
        );
    }
}