<?php

namespace App\Consts\Api;

class MessageConst
{

    //HTTP_REQUEST_SUCCEED
    public const OK = 200;
    public const CREATED = 201;
    public const No_Content = 204;

    //HTTP_REQUEST_FAILED
    public const Bad_Request = 400;
    public const Unauthorized = 401;
    public const Payment_Required = 403;
    public const Forbidden = 404;
    public const Not_Found = 405;
    public const Not_Acceptable = 406;
    public const Expectation_Failed = 417;

    //Internal ServerError
    public const Internal_Server_Error = 500;
    public const Not_Implemented = 501;
    public const Bad_Gateway = 502;
    public const Service_Unavailable = 503;
    public const Gateway_Timeout = 504;
    public const HTTP_Version_Not_Supported = 505;
    public const Not_Extended = 510;

    // Times Add for Carbon
    public const second = 60;
    public const Month = 30;
}

