<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * URL xác minh người dùng.
     */
    public $verificationUrl;

    /**
     * Tạo một instance mới của thông điệp.
     *
     * @param string $verificationUrl
     */
    public function __construct($verificationUrl)
    {
        $this->verificationUrl = $verificationUrl;
    }

    /**
     * Xây dựng thông điệp.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.Verification')
            ->with(['verificationUrl' => $this->verificationUrl]);
    }
}
