@extends('mail.Common.Template')
@include('mail.Common.Header')
@section('Content')
    You got an edit comment in your article .

    Your article:                          {{$name}}
    Your article title:                    {{$title}}
    Your article content:                  {{$content}}

    Your selected mountain is located in:  {{$prefecture}}


    check it and confirm there are no wrong things .
@endsection
@include('mail.Common.Footer')
