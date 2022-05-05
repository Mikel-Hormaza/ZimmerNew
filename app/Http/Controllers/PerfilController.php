<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Redirect;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index() {
        $user=Auth::user(); /* Gorde $user aldagaian saioa hasi duen erabiltzailea eta bistara bidali */
        return view('perfil.index', ['user'=>$user]);
    }

    function rol($id) {
        $user = User::find($id);
        return view('perfil.rol', ['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=Auth::user();
        return view('perfil.index', ['user'=>$user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();
        return redirect()->action([AdminController::class, 'index']);
    }

    public function updateRol(Request $request, $id, $rol)
    {
        $user = User::find($id);
        if ($rol<2){
            $user->fill($request->all());
            $user->save();
            return Redirect::to('/admin')->with('success', "Erabiltzailearen baimenak aldatu dira");
        }else{
            return Redirect::to('/admin')->with('error', "Erabiltzailearen baimenak ezin dira aldatu erabiltzailea 'superadmin' baimenak dituelako");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
