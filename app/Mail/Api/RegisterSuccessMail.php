<?php

namespace App\Mail\Api;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nickName, $address)
    {
        $this->nickName = $nickName;
        $this->address = $address;
     }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->address)
            ->subject('登録が完了致しました。')
            ->text('mail.Api.RegisterSuccess')
            ->with([
                'name' => $this->nickName,
            ]);
    }
}
