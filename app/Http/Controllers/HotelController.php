<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Comment;
use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller {

    function index() {
        $user_id = Auth::user()->id;
        $favs = Favorito::where("user_id", "LIKE", Auth::user()->id)->get("hotel_id");
        return view("hotel.index", ["favs" => $favs, "user_id" => $user_id]);
    }

    function show($id) {
        $user = Auth::user();
        $comentarios = Comentario::where("hotel_id", "LIKE", $id)->orderBy("created_at", "DESC")->get();
        $fav = sizeof(Favorito::where("hotel_id", "LIKE", $id)->where("user_id", "LIKE", $user->id)->get()) > 0;
        return view("hotel.show", ["id" => $id, "user" => $user, "comentarios" => $comentarios, "fav" => $fav]);
    }

}
