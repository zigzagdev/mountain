<?php

namespace App\Mail\Api;

use App\Consts\Api\Prefecture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ArticleUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($findArticle)
    {
        $this->nickName = $findArticle->nick_name;
        $this->title = $findArticle->title;
        $this->content = Str::limit($findArticle->content, 15, '...');
        $this->prefecture = Prefecture::eachPrefecture[$findArticle->prefecture];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'))
            ->subject('記事の更新が完了致しました。')
            ->text('mail.Api.ArticleUpdateSuccess')
            ->with([
                'name' => $this->nickName,
                'title' => $this->title,
                'content' => $this->content,
                'prefecture' => $this->prefecture
            ]);
    }
}
