@extends('layouts.app')

@section('content')

<div class="container my-5">

    <hotel-list favs="{{ $favs }}"></hotel-list>

</div>

@endsection