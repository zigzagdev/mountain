<?php

namespace App\Mail\Api;

use App\Consts\Api\Prefecture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CommentUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailUserInform)
    {
        $this->title = $mailUserInform->title;
        $this->content = Str::limit($mailUserInform->content, 15, '...');
        $this->prefecture = Prefecture::eachPrefecture[$mailUserInform->prefecture];
        $this->content = $mailUserInform->content;
        $this->name = $mailUserInform->name;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject('コメントの更新が完了致しました。')
            ->text('mail.Api.CommentUpdateSuccess')
            ->with([
                'name' => $this->nickName,
                'title' => $this->title,
                'content' => $this->content,
            ]);
    }
}
