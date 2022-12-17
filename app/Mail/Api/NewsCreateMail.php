<?php

namespace App\Mail\Api;

use App\Consts\Api\Prefecture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NewsCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recordNews, $admin)
    {
        $this->nickName = $admin->nick_name;
        $this->newsTitle = $recordNews->news_title;
        $this->newsContent = Str::limit($recordNews->news_content, 15, '...');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject('ニュースの投稿が完了致しました。')
            ->text('mail.Api.NewsSuccess')
            ->with([
                'name' => $this->nickName,
                'newsTitle' => $this->newsTitle,
                'newsContent' => $this->newsContent,
            ]);
    }
}
