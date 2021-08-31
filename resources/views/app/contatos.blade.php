@extends('layouts.login')

@section('content')
    <contato-component token_csrf="{{@csrf_token()}} ></contato-component>
@endsection