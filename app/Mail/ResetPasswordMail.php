<?php

namespace App\Mail;

use App\AppUser;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AppUser $arrUserDetails)
    {
        $this->name  = $arrUserDetails->name;
        $this->otp   = $arrUserDetails->reset_password_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.resetpassword')->with([
                        'name'=>$this->name,
                        'otp'=>$this->otp
                    ]);            
    }
}
