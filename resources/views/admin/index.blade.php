@extends('layouts.app')

@section('content')

<div class="container my-5">

    <h3 class="mb-4">Erabiltzaile zerrenda</h3>

    @foreach($usuarios as $user)
        <div class="d-flex justify-content-between align-items-center border rounded shadow-sm px-3 py-2 mb-3">
            <div class="d-flex align-items-center gap-3">
                @if($user->rol == 1)
                    <i class="fa fa-user-plus fs-2 text-muted"></i>
                @elseif($user->rol == 0)
                    <i class="fa fa-user fs-2 text-muted"></i>
                @endif
                <div>
                    <div class="d-flex gap-2">
                        <span>{{ $user->name }}</span>
                        <span class="text-muted">{{ $user->created_at }}</span>
                    </div>
                    <span>{{ $user->email }}</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <form action="/erabiltzailea/{{ $user->id }}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-danger">X</button>
                </form>
                <!-- <form action="" method="POST">
                    @csrf
                    @method("UPDATE")
                    <select name="rol">
                        <option value="0">Erabiltzaile arrunta</option>
                        <option value="1">Administradorea</option>
                    </select>
                    <button type="submit" class="btn btn-danger">X</button>
                </form> -->
            </div>
        </div>
    @endforeach

</div>

@endsection