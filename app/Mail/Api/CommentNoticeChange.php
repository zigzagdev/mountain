<?php

namespace App\Mail\Api;

use App\Consts\Api\Prefecture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class CommentNoticeChange extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailUserInform)
    {
        $this->name = $mailUserInform->adminName;
        $this->articleTitle = $mailUserInform->articleTitle;
        $this->articleContent = Str::limit($mailUserInform->articleContent, 15, '...');
        $this->commentTitle = $mailUserInform->commentTitle;
        $this->content = Str::limit($mailUserInform->content, 15, '...');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject('コメントの更新がされました。')
            ->text('mail.Api.CommentNoticeChange')
            ->with([
                'name' => $this->name,
                'articleTitle' => $this->articleTitle,
                'articleContent' => $this->articleContent,
                'commentTitle' => $this->commentTitle,
                'content' => $this->content
            ]);
    }
}
