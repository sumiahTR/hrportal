<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalaryCredited extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $filename;
    protected $staff;
    protected $mailBody;

    public function __construct($filename, User $staff, $mailBody)
    {
        $this->filename = $filename;
        $this->staff = $staff;
        $this->mailBody = $mailBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('financemarunadan@gmail.com')
                ->view('app.emails.salary')
                ->attachFromStorage($this->filename)
                ->with([
                    'name' => $this->staff->name,
                    'mailBody' => $this->mailBody,
                ]);
    }
}
