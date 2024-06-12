@extends('layout')

@section('content')

<Parts
    :page="{{ json_encode($page) }}"
    :search="{{ json_encode($search) }}"
></Parts>

@endsection
