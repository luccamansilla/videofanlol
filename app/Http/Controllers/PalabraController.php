<?php

namespace App\Http\Controllers;

use App\Models\Palabra;
use Illuminate\Http\Request;

class PalabraController extends Controller
{
    public function store(Request $request, $video_id)
    {
        $todasPalabras = explode('-', $request->palabrasClaves);
        foreach ($todasPalabras as $p) {
            $palabra = new Palabra;
            $palabra->video_id = $video_id;
            $palabra->palabra = $p;
            $palabra->save();
        }
    }
    public function destroy($idVideo)
    {
        $palabras = Palabra::where('video_id', $idVideo)->get();

        // Eliminar las palabras
        foreach ($palabras as $palabra) {
            $palabra->delete();
        }
    }
}
