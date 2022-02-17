<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {
    
    function index() {

        $users = User::all();

        return view("admin.index", ["usuarios" => $users]);

    }

    function delete_user($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect("/admin");
    }
    
}
