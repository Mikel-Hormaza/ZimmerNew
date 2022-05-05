@extends('layouts.app')

@section('content')

@if ($user)

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($user->rol < 2) <div class="card">
                <div class="card-header"><strong>{{$user->name}}</strong> erabiltzaileak baimena hau dauka:
                    @if ($user->rol == 0)
                    <strong>erabiltzailea (ez da administratzailea)</strong>
                    @elseif($user->rol == 1)
                    <strong>administratzailea</strong>
                    @endif
                    . Baimena aldatzeko, aukeratu baimen berria
                </div>
                <div class="card-body">
                    <form id="formulario" class="d-inline-flex" method="POST" action="/profile/{{ $user->id}}/{{ $user->rol}}">
                        @csrf
                        {{ method_field('PUT') }}
                        <select name="rol" id="rol">
                            <option hidden value="-1">Aukeratu baimen berria</option>
                            <option value="1">Admin</option>
                            <option value="0">Erabiltzaile orokorra</option>
                        </select>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="gordeBotoia" type="submit" class="btn btn-primary m-1">
                                    {{ __('Gorde') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
        @else
        <p class="alert alert-warning"><strong>{{$user->name}}</strong> erabiltzailea superadmin bat da, beraz ezin dira bere baimenak aldatu</p>
        @endif
    </div>
</div>
</div>
@endif

@section('scriptsErabiltzaile')
@parent

<script type="application/javascript">
    class erabiltzailea {
        constructor(p_inizialak, p_izena, p_email) {
            this._inizialak = p_inizialak;
            this._izena = p_izena;
            this._email = p_email;
        }

        /* getterrak */
        inizialak() {
            return this._inizialak;
        }

        izena() {
            return this._izena;
        }

        email() {
            return this._email
        }

        /* inizialen luzeera gehienez 2 eta gutxienez 0 izatea eta letra larriz egotea konprobatu
        baldintzak ez badira betetzen, return false */
        balidatuInizialak() {
            let inizialak = this.inizialak();
            if ((inizialak.length == 2) || (inizialak.length == 1) && (inizialak === inizialak.toUpperCase())) {
                return true;
            } else {
                return false;
            }
        }

        /* izena soilik letrak izatea
        baldintza ez bada betetzen, return false */
        balidatuIzena() {
            let izena = this.izena();
            let patroia = /^[A-Za-z\s]+$/ /* \s-renik hutsuneak onartzen ditu */
            return patroia.test(izena);
        }

        /* emaila emailaren formatua izatea. Bestela false */
        balidatuEmaila() {
            let email = this.email();
            let patroia = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return patroia.test(email);

        }
    }
</script>
@endsection


<script type="application/javascript">
    $(document).ready(function() {
        $("#name").on("keyup", function() {
            let initials_list = $(this).val().split(" ");
            let initials = "";
            for (let i = 0; i < initials_list.length; i++) {
                if (initials_list[i].length > 0) {
                    initials += initials_list[i].charAt(0).toUpperCase();
                    if (initials.length == 2)
                        break;
                }
            }
            $("#initials").val(initials);
        });

        /* "gorde" klikatzerakoan balidazioak egin formularioa bidali baino lehen*/
        $("#gordeBotoia").on("click", function() {
            let erabiltzaile = new erabiltzailea(
                $("#initials").val(),
                $("#name").val(),
                $("#email").val()
            );
            ezabatuErroreMezuak();
            balidatuEtaBidaliFormularioa(erabiltzaile);
        });
    });

    /* konprobatzaileak deitu. Konprobatzaileak true itzultzen badu, formularioa bidali*/
    function balidatuEtaBidaliFormularioa(erabiltzaile) {
        if (konprobatuDatuGuztiak(erabiltzaile)) {
            $("#formulario").submit();
            return true;
        } else {
            return false;
        }
    }

    /* hiru inputetan testua dagoela konprobatu
    bat hutsik badago - return false*/
    function konprobatuDatuGuztiak(erabiltzaileDatuak) {
        let datuakOk = true;
        if ((erabiltzaileDatuak.inizialak().length == 0) || (!erabiltzaileDatuak.balidatuInizialak())) {
            sortuErroreMezua("izena");
            datuakOk = false;
        }
        if ((erabiltzaileDatuak.izena().length == 0) || (!erabiltzaileDatuak.balidatuIzena())) {
            sortuErroreMezua("izena");
            datuakOk = false;
        }
        if ((erabiltzaileDatuak.email().length == 0) || (!erabiltzaileDatuak.balidatuEmaila())) {
            sortuErroreMezua("helbide elektronikoa");
            datuakOk = false;
        }
        return datuakOk;
    }

    /* ezabatu erroreen span-ean dauden errore mezuak */
    function ezabatuErroreMezuak() {
        $("#erroreMezua").empty();
    }

    /* testua jasotzen du parametro bezala eta errorea span-ean sartzen du */
    function sortuErroreMezua(testua) {
        var mezua = $("<p></p>").text("Errorea '" + testua + "' atributoan. Mesedez, saiatu berriro.");
        mezua.addClass("alert alert-warning").addClass("mt-2");
        $("#erroreMezua").append(mezua);
    }
</script>

@endsection