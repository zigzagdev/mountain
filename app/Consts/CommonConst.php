<?php

namespace App\Consts;

class CommonConst
{

    // Common Messages
    public const FAILED = "%sに失敗しました。";
    public const REGISTER_FAILED = "%sの登録に失敗しました。";
    public const UPDATE_FAILED = "%sの更新に失敗しました。";
    public const SEND_FAILED = "%sの送信に失敗しました。";
    public const FETCH_FAILED = "%sの取得に失敗しました。";
    public const AUTHENTICATE_FAILED = "%sの認証に失敗しました。";
    public const DELETE_FAILED = "%sの削除に失敗しました。";
    public const STATUS_NOT_FOUND = "ステータスが存在しません。";
    public const SESSION_FAILED = "セッションが切れました。再度ログインをお願い致します。";

    //Specific Messages
    public const ERR_01 = "メールアドレスあるいはパスワードが間違っています。";
    public const ERR_02 = "会員登録が不備の状態です。再度最初から手続きを行ってください。";
    public const ERR_03 = "メールアドレスが正しくありません。";
    public const ERR_04 = "パスワードが正しくありません。";
    public const ERR_05 = "データが存在しません。";
    public const ERR_06 = "認証コードが正しくありません。";
    public const ERR_07 = "認証コードが有効でありません。もう一度認証コードを発行お願い致します。";
    public const ERR_08 = "このデータは既に登録済みとなっています。";
    public const ERR_09 = "有効期限が切れています。";
    public const ERR_10 = "既にメールアドレスは利用されています。別のメールアドレスを利用してください。";
    public const ERR_11 = "この投稿は現在閲覧出来ません。";
    public const ERR_12 = "この記事は現在閲覧出来ません。";
    public const ERR_13 = "既にアカウント登録されています。ログイン画面からログインしてください。";

}
