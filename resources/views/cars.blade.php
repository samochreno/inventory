@extends('layout')

@section('content')

<Cars
    :page="{{ json_encode($page) }}"
    :search="{{ json_encode($search) }}"
    :filter="{{ json_encode($filter) }}"
></Cars>

@endsection
