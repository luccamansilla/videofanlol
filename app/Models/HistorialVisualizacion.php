<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HistorialVisualizacion extends Model
{
    use HasFactory;
    protected $table = 'historial_visualizaciones';

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comprobarVisualizaciones($id)
    {
        $user = User::find($id);
        $hoy = date('Y-m-d');
        $cincoDiasAnteriores = array();
        $obtieneBeneficio = false;
        //Obtengo los ultimos cinco dias, sin tomar el dia de hoy
        for ($i = 1; $i <= 5; $i++) {
            $diaAnterior = date('Y-m-d', strtotime("-$i days", strtotime($hoy)));
            $cincoDiasAnteriores[] = $diaAnterior;
        }

        //consulta desde la base de datos para obtener la cantidad de visualizaciones del usuario por dia
        //SELECT sum(cantidad) 
        // FROM `historial_visualizaciones` 
        // INNER JOIN videos ON videos.id = historial_visualizaciones.video_id 
        // WHERE videos.user_id = $user and historial_visualizaciones.fecha = $fecha;
        foreach ($cincoDiasAnteriores as $fecha) {
            $cantidadVisualizaciones = DB::table('historial_visualizaciones')
                ->join('videos', 'videos.id', '=', 'historial_visualizaciones.video_id')
                ->where('videos.user_id', $user->id)
                ->where('historial_visualizaciones.fecha', $fecha)
                ->sum('historial_visualizaciones.cantidad');
            //Verifico que la cantidad de visualizaciones total del usuario(viendo todos sus videos) en la $fecha sea mayor o igual a 100
            if ($cantidadVisualizaciones >= 100) {
                $obtieneBeneficio = true;
            } else {
                //En caso de que un dia de los 5 no sea mayor a 100, setea el beneficio del usuario en falso y sale de loop devolviendo falso.
                $obtieneBeneficio = false;
                return false;
            }
        }
        if ($obtieneBeneficio) {
            //en caso de que el temporal tenga verdadero
            return true;
        }
    }
}
