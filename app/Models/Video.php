<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'ubicacion_id', 'titulo', 'descripcion', 'path', 'fecha_grabacion', 'duracion'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }
    public function palabras()
    {
        return $this->hasMany(Palabra::class);
    }
    public function historial()
    {
        return $this->hasMany(HistorialVisualizacion::class);
    }
    public function visualizaciones($id)
    {
        $video = Video::find($id);
        $historial = $video->historial;
        $total = 0;
        if (count($historial)) {
            foreach ($historial as $h) {
                $total += $h->cantidad;
            }
        }
        return $total;
    }
    public function videosRelacionados($palabras, $id)
    {
        $videoIds = array();
        foreach ($palabras as $p) {
            $vid = DB::table('palabras')
                ->selectRaw('DISTINCT(video_id)')
                ->whereRaw('UPPER(palabras.palabra) LIKE UPPER(?)', ["%$p%"])
                ->pluck('video_id');
            // Agregar los IDs de los videos relacionados a la lista, asegurándote de que sean diferentes al video buscado antes
            foreach ($vid as $v) {
                if ($id !== $v) {
                    $videoIds[] = $v;
                }
            }
        }
        // Eliminar duplicados y obtener los objetos completos de Video
        $videos = Video::whereIn('id', array_unique($videoIds))->take(3)->get();
        return $videos;
    }
    public function palabrasVideo($id)
    {
        $palabras = Palabra::where('video_id', $id)->get();
        return $palabras;
    }
}
