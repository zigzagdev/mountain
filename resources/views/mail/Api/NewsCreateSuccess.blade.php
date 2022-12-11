@extends('mail.Common.Template')
@include('mail.Common.Header')
@section('Content')
    your news was created correctly !

    Your adminName:                        {{$name}}
    Your news title:                       {{$newsTitle}}
    Your news content:                  {{$newsContent}}

    Your selected mountain is located in:  {{$prefecture}}


    check it and confirm there are no wrong things .
@endsection
@include('mail.Common.Footer')
