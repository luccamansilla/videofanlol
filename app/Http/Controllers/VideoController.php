<?php

namespace App\Http\Controllers;

use App\Models\HistorialVisualizacion;
use App\Models\Palabra;
use App\Models\Ubicacion;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Nette\Utils\DateTime;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        $busqueda = trim($request->busqueda);
        $videos = Video::select('videos.*')
            ->distinct()
            ->join('users', 'videos.user_id', '=', 'users.id')
            ->join('palabras', 'palabras.video_id', '=', 'videos.id')
            ->where('titulo', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('users.username', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('palabras.palabra', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('videos.created_at', 'LIKE', '%' . $busqueda . '%')
            ->orderBy('videos.created_at', 'desc')
            ->get();
        // esta consulta filtra los videos con la busqueda, teniendo en cuenta el titulo, usuario que suubio el video, palabras claves y fecha
        //consulta relizada en MySQL = 
        //SELECT DISTINCT videos.*
        // FROM videos 
        // INNER JOIN users ON videos.user_id = users.id
        // INNER JOIN palabras ON palabras.video_id = videos.id
        // WHERE titulo LIKE '%busqueda%' OR users.username LIKE '%busqueda%' OR palabras.palabra LIKE '%busqueda%' OR videos.created_at LIKE '%busqueda%'
        // ORDER BY videos.created_at DESC;
        return view('videos.index', compact('videos', 'busqueda'));
    }

    public function ver($idVideo)
    {
        //cargo visualizacion cuando entra a ver el video
        $hoy = new DateTime();
        $fechaActual = $hoy->format('Y-m-d');

        if (Auth::user()) { //en caso de que sea un usuario registrado, se fija si ya vio el video en el dia y en ese caso le suma a el atributo cantidad
            $visualizacionExiste = HistorialVisualizacion::where('user_id', Auth::user()->id)->where('video_id', $idVideo)->where('fecha', $fechaActual)->first();
        } else {
            $visualizacionExiste = HistorialVisualizacion::where('user_id', null)->where('video_id', $idVideo)->where('fecha', $fechaActual)->first();
        }
        if ($visualizacionExiste) {
            $visualizacionExiste->cantidad += 1;
            $visualizacionExiste->save();
        } else {
            // La visualización no existe, puedes crear una nueva visualización
            $visualizacion = new HistorialVisualizacion;
            //en caso de que haya un usuario registrado, le asigna el user_id
            if (Auth::user()) {
                $visualizacion->user_id = Auth::user()->id;
            }
            // en caso de que no este registrado, registra la visualizacion pero no el user_id
            $visualizacion->video_id = $idVideo;
            $visualizacion->fecha = $fechaActual;
            $visualizacion->cantidad = 1;
            $visualizacion->save();
        }
        $video = Video::find($idVideo);

        $palabras = Palabra::where('video_id', $video->id)->pluck('palabra'); //pluck solo trae el atributo que le mando en el parentesis
        $videos = $video->videosRelacionados($palabras, $video->id); //obtengo los videos relacionados con las palabras del video elegido
        $cantidadVideos = count($videos);
        //En caso de que la cantidad de videos relacionados sean menos de 3, obtengo los videos mas recientes hasta llegar a 3.
        if ($cantidadVideos < 3) {
            $idsVideos = $videos->pluck('id')->toArray();
            $cantFaltante = 3 - $cantidadVideos; //obtengo la cantidad de videos que me faltan
            $videosRecientes = Video::whereNotIn('id', $idsVideos)
                ->orderBy('created_at', 'desc')
                ->take($cantFaltante)
                ->get(); //obtengo los videos
            $videos = $videos->concat($videosRecientes)->take(3); //concateno ambos arrays y los dejo en la variable videos
        }
        return view('videos.ver', compact('video', 'videos'));
    }

    public function store(Request $request, UbicacionController $controladorUbicacion, PalabraController $controladorPalabras)
    {
        // validaciones de los input
        if (Auth::user()->beneficio === 1) { //usuario tiene beneficio
            $request->validate([
                'archivo' => 'required|mimes:mp4|max:1048576', // maximo de 1GB (tamaño en Kb)
                'minutos' => 'max:2',  // maximo 30 minutos
                'titulo' => 'required',
                'descripcion' => 'required',
                'grabacion' => 'required',
                'latitud' => 'required',
                'palabrasClaves' => 'required',
            ], [
                'archivo.mimes' => 'Solo se pueden subir archivos de tipo MP4.',
                'archivo.required' => 'Debe subir el archivo del video.',
                'archivo.max' => 'El archivo no puede pesar mas de 1GB.',
                'titulo.required' => 'El titulo es obligatorio',
                'minutos.max' => 'El video debe ser de maximo 30 minutos',
                'descripcion.required' => 'La descripción es obligatoria',
                'grabacion.required' => 'Debe ingresar la fecha de la grabación',
                'latitud.required' => 'Debe clickear en el mapa la ubicación de la grabación',
                'palabrasClaves.required' => 'Debe ingresar al menos una palabra clave',
            ]);
        } else { //usuario no tiene beneficio
            $request->validate([
                'archivo' => 'required|mimes:mp4|max:512000', // maximo de 500MB (tamaño en Kb)
                'minutos' => 'max:10',  // maximo 10 minutos
                'titulo' => 'required',
                'descripcion' => 'required',
                'grabacion' => 'required',
                'latitud' => 'required',
                'palabrasClaves' => 'required',
            ], [
                'archivo.mimes' => 'Solo se pueden subir archivos de tipo MP4.',
                'archivo.required' => 'Debe subir el archivo del video.',
                'archivo.max' => 'El archivo no puede pesar mas de 500MB.',
                'titulo.required' => 'El titulo es obligatorio',
                'minutos.max' => 'El video debe ser de maximo 10 minutos',
                'descripcion.required' => 'La descripción es obligatoria',
                'grabacion.required' => 'Debe ingresar la fecha de la grabación',
                'latitud.required' => 'Debe clickear en el mapa la ubicación de la grabación',
                'palabrasClaves.required' => 'Debe ingresar al menos una palabra clave',
            ]);
        }
        //obtengo el archivo y lo guardo en la carpeta public/videos
        $file = $request->file('archivo');
        $file->move('videos', $file->getClientOriginalName());
        $path = $file->getClientOriginalName();

        //guardo la ubicacion en la base de datos y la obtengo el la linea siguiente 
        $controladorUbicacion->store($request);
        $ubicacion = Ubicacion::latest()->first();

        //guardo el video en la base de datos
        $video = Video::create([
            'user_id' => Auth::user()->id,
            'ubicacion_id' => $ubicacion->id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'path' => $path,
            'duracion' => $request->duracionVideo,
            'fecha_grabacion' => $request->grabacion,
        ]);
        $video->save();

        //una vez que guardo el video, obtengo el id y guardo las palabras claves asociando el id del video
        $controladorPalabras->store($request, $video->id);
        return redirect()->route('video.misvideos', Auth::user()->id);
    }


    public function show($usuario)
    {
        //obtengo los videos del usuario
        $user = User::where('username', $usuario)->first();
        $videos = Video::where('user_id', $user->id)->get();
        return view('videos.misvideos', compact('videos'));
    }
    public function subir($usuario)
    {
        $user = User::find($usuario);
        //Obtengo el usuario y compruebo sus visualizaciones para el beneficio 
        $visualizacion = new HistorialVisualizacion;
        $obtieneBeneficio = $visualizacion->comprobarVisualizaciones($user->id);
        if ($obtieneBeneficio) {
            $user->beneficio = 1;
        } else {
            $user->beneficio = 0;
        }
        $user->save();

        return view('videos.subirvideo', compact('user'));
    }

    public function editar($id)
    {
        $user = Auth::user();
        $video = Video::find($id);
        $palabras = Palabra::where('video_id', $video->id)->pluck('palabra');
        return view('videos.editar', compact('video', 'user', 'palabras'));
    }
    public function update(Request $request, Video $video, UbicacionController $controladorUbicacion, PalabraController $controladorPalabras)
    {
        // dd($request);
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'grabacion' => 'required',
            'latitud' => 'required',
            'palabrasClaves' => 'required',
        ], [
            'titulo.required' => 'El titulo es obligatorio',
            'descripcion.required' => 'La descripción es obligatoria',
            'grabacion.required' => 'Debe ingresar la fecha de la grabación',
            'latitud.required' => 'Debe clickear en el mapa la ubicación de la grabación',
            'palabrasClaves.required' => 'Debe ingresar al menos una palabra clave',
        ]);
        //Obtengo la ubicacion actual y verifico que si no es la misma, la actualizo
        $long = $video->ubicacion->longitud;
        $lat = $video->ubicacion->latitud;
        //Si la latitud y longitud son diferentes, cambio la ubicacion guardada
        if ($long !== $request->longitud &&  $lat !== $request->latitud) {
            $controladorUbicacion->update($video->ubicacion, $request->latitud, $request->longitud);
        }
        //elimino todas las palabras claves del video
        $controladorPalabras->destroy($video->id);
        //guardo las nuevas palabras
        $controladorPalabras->store($request, $video->id);
        //actualizo los datos del video
        $video->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_grabacion' => $request->grabacion,
        ]);
        return redirect()->route('video.misvideos', Auth::user()->id);
        // dd($video);
    }

    public function destroy(Request $request)
    {
        // obtengo el video y lo borro de la base de datos
        $video = Video::find($request->id);
        $video->delete();
        return redirect()->route('video.misvideos', Auth::user()->username)->with('success', 'El video fue eliminado correctamente.');
    }
}
