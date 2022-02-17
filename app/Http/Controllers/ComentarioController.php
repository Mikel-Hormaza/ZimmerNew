<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller {
    
    function create(Request $request) {

        $comentario = new Comentario();
        $comentario->contenido = $request->get("contenido");
        $comentario->hotel_id = $request->get("hotel_id");
        $comentario->user_id = $request->get("user_id");
        $comentario->save();

        return redirect($request->url());

    }

    function handle(Request $request, $comentario_id) {

        $comentario = Comentario::FindOrFail($comentario_id);

        if ($request->get("method") == "UPDATE") {
            $comentario->contenido = $request->get("contenido");
            $comentario->save();
        } else {
            $comentario->delete();
        }

        // $hotel_id = strval($request->get("hotel_id"));

        return redirect($request->get("next_url"));

    }
}
