@extends('layouts.app')

@section('content')

<div class="container my-5">

    <h3 class="mb-4">Erabiltzaile zerrenda</h3>

    @foreach($usuarios as $user)
    <div class="d-flex row py-1 justify-content-between align-items-center border rounded shadow-sm px-3 py-2 mb-3">
        <div class="d-flex col-12 col-sm-6 justify-content-center justify-content-sm-start align-items-center gap-3">
            @if($user->rol == 0)
            <img class="userAdminIcon" src="img/user.png" alt="">
            @elseif($user->rol == 1)
            <img class="userAdminIcon" src="img/profile.png" alt="">
            @elseif($user->rol == 2)
            <img class="userAdminIcon" src="img/management.png" alt="">
            @endif
            <div>
                <div class="d-flex gap-2">
                    <span>{{ $user->name }}</span>
                    <span class="text-muted userCreationData">{{ $user->created_at }}</span>
                </div>
                <span>{{ $user->email }}</span>
            </div>
        </div>
        <div class="d-flex gap-2 col-12 col-sm-6 mt-1 mt-sm-0 justify-content-center justify-content-sm-end">
            @if(Auth::User()->rol == 2)
            @if(!($user->rol == 2))
            <form action="/profile/rol/{{ $user->id }}">
                <button type="submit" class="btn btn-primary"><a>baimenak aldatu</a></button>
            </form>
            <form action="/erabiltzailea/{{ $user->id }}" method="POST">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger">X</button>
            </form>
            @endif
            @endif
        </div>
    </div>
    @endforeach

</div>

@endsection