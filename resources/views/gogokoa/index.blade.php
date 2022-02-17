@extends('layouts.app')

@section('content')

<div class="container my-5">

    <fovoritos-list favs="{{ $favs }}"></fovoritos-list>

</div>

@endsection