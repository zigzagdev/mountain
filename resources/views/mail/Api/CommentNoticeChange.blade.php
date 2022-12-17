@extends('mail.Common.Template')
@include('mail.Common.Header')
@section('Content')
    You got an edit comment in your article .

    Your article:                          {{$name}}
    Your article title:                    {{$articleTitle}}
    Your article content:                  {{$articleContent}}

    Updated Comment was:                   {{$commentTitle}}
    Updated contents were :                 {{$content}}

    check it and confirm there are no wrong things .
@endsection
@include('mail.Common.Footer')
