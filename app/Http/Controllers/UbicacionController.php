<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    public function store(Request $request)
    {
        $ubicacion = new Ubicacion;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->latitud = $request->latitud;
        $ubicacion->save();
    }

    public function update(Ubicacion $ubicacion, $latitud, $longitud)
    {
        $ubicacion->latitud = $latitud;
        $ubicacion->longitud = $longitud;
        $ubicacion->save();
    }
}
