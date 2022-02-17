@extends('layouts.app')

@section('content')

<div class="container my-5">

    <hotel-details :id="{{ $id }}" user_id="{{ $user->id }}" fav="{{ $fav }}" class="mb-5"></hotel-details>

    <h4 class="my-4">Comentarios</h4>

    @if($user)
        <form id="comment-form" method="POST" action="/hoteles/{{ $id }}" class="mb-4">
            @csrf
            <input type="hidden" value="{{ $id }}" name="hotel_id">
            <input type="hidden" value="{{ $user->id }}" name="user_id">
            <div class="d-flex align-items-center gap-4">
                <div>
                    <div class="user-icon bg-success">
                        <span>{{ $user->initials }}</span>
                    </div>
                </div>
                <div class="d-flex flex-column w-100">
                    <span class="fw-bold">{{ $user->name }}</span>
                    <input id="comment-input" type="text" autocomplete="off" placeholder="Añade un comentario publico" name="contenido" required>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-3 mt-3">
                <button id="comment-btn" type="submit" class="btn btn-primary">Comentar</button>
            </div>
        </form>
    @endif
    @if(sizeof($comentarios) == 0)
        <p id="no-comments" class="text-muted">Este hotel no tiene comentarios</p>
    @endif
    @foreach ($comentarios as $comentario)
        <comentario :comentario="{{ $comentario }}" :usuario="{{ App\Models\User::find($comentario->user_id) }}" :auth="{{ Auth::user() }}"></comentario>
    @endforeach
    
</div>

@endsection