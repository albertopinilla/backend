<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertSotck extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $mail;
    protected $data;

    public function __construct($title,$mail,$data)
    {
        $this->title = $title;
        $this->mail = $mail;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->mail)
            ->subject($this->title)
            ->view('emails.notification-stock')
            ->with([
                'title' => $this->title,
                'data' => $this->data
            ]);
    }
}
