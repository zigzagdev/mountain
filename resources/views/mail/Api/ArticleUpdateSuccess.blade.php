@extends('mail.Common.Template')
@include('mail.Common.Header')
@section('Content')
    your article was updated correctly !

    Your adminName:                        {{$name}}
    Your article title:                    {{$title}}
    Your article content:                  {{$content}}

    Your selected mountain is located in:  {{$prefecture}}


    check it and confirm there are no wrong things .
    @include('mail.Common.Footer')
@endsection
