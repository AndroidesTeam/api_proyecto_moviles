<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluacion;
use App\Profesor;
use App\Comentario;
use App\Curso;
use App\Set;
use function GuzzleHttp\json_decode;

class EvaluacionController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'calificacion' => 'required',
            'fecha' => 'required',  
            'id_usuario' => 'required|exists:users,id',
            'id_curso' => 'required|exists:curso,id'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }

        $set = $request->set;
        $evaluacion = Evaluacion::create([
                'id_user'=>$request->id_usuario,
                'fecha'=>$request->fecha,
                'id_curso'=>$request->id_curso
            ]);
        $calificacion=0;
        foreach ($set as $sets) {
            $sets = json_decode($sets);
            $respuesta = [
                'id_evaluacion'=>$evaluacion->id,
                'id_pregunta'=>$sets->id_pregunta,
                'puntuacion'=>$sets->puntuacion
           ];
            $s=Set::create($respuesta);
            $calificacion+= $s->puntuacion;
        }
        $calificacion = $calificacion/count($request->set);
        $evaluacion->calificacion=$calificacion;
        $evaluacion->save();
		
		$comentario = new Comentario;
		$comentario->id_user = $request->id_usuario;
		$comentario->id_curso = $request->id_curso;
		$comentario->texto = $request->comentario;
		$comentario->fecha = $request->fecha;
		$comentario->save();
		
        return $this->success($sets);
    }

    public function obtenerPromedio(Request $request){
        $evaluaciones = Evaluacion::join('curso','curso.id','=','evaluacion.id_curso')
        ->where('id_curso',$request->id_curso);
        $suma=$evaluaciones->sum('calificacion');
        $promedio = $suma/$evaluaciones->count();

        $cuantos = $evaluaciones->count();
        $curso= Curso::where('id',$request->id_curso)->first();
        $profesor = Profesor::find($curso->id_profesor);
        $profesor->promedio = $promedio;
        $profesor->cuantos= $cuantos;

        $cont =1;
        $preguntas=array();
        while($cont < 9){
            $evaluacion = $this->porPregunta($cont,$request->id_curso);
            $total_respuestas = $evaluacion->count();
            $total_uno= $evaluacion->where('set.puntuacion',1)->count();
            $evaluacion = $this->porPregunta($cont,$request->id_curso);
            $total_dos= $evaluacion->where('set.puntuacion',2)->count();
            $evaluacion = $this->porPregunta($cont,$request->id_curso);
            $total_tres= $evaluacion->where('set.puntuacion',3)->count();
            $evaluacion = $this->porPregunta($cont,$request->id_curso);
            $total_cuatro= $evaluacion->where('set.puntuacion',4)->count();

            array_push($preguntas,[
                'pregunta'=>$cont,
                'total'=>$total_respuestas,
                'respondio_1'=>$total_uno,
                'respondio_2'=>$total_dos,
                'respondio_3'=>$total_tres,
                'respondio_4'=>$total_cuatro,
            ]);
            $cont++;
        }

        $result = ['profesor'=>$profesor,'preguntas'=>$preguntas];

        return $this->success($result);
    }

    //funcion auxiliar
    public function porPregunta($pregunta,$id_curso){
        $evaluaciones= Evaluacion::join('curso','curso.id','=','evaluacion.id_curso')
        ->join('set','set.id_evaluacion','=','evaluacion.id')
        ->where('id_pregunta',$pregunta)
        ->where('id_curso',$id_curso);

        return $evaluaciones;
    }

    public function obtenerPromedioTodos(Request $request){
        $profesores = Profesor::get();
        $respuesta=array();
        foreach ($profesores as $profesor) {
            $evaluaciones = Evaluacion::join('curso','=','id_evaluacion')
            ->where('id_profesor',$profesor->id_profesor);
            $suma=$evaluaciones->sum('calificacion');
            $promedio = $suma/$evaluaciones->count();
            array_push($respuesta,['profesor'=>$profesor->nombre.' '.$profesor->ap_paterno.' '.$profesor->ap_materno,'promedio'=>$promedio]);
        }

        return $this->success($respuesta);
    }

    public function actualizar(Request $request){
        $array = $request->all();
        $data = Evaluacion::where('id_user',$request->id_usuario)
		->where('id_curso',$request->id_curso)
		->first();
		
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
		$id_evaluacion = $data->id;
		$set = $request->set;
        foreach ($set as $sets) {
            $sets = json_decode($sets);
            $s = Set::where('id_evaluacion',$id_evaluacion)
			->where('id_pregunta',$sets->id_pregunta)
			->update(['puntuacion'=>$sets->puntuacion]);
        }
		$comentario = Comentario::where('id_curso',$request->id_curso)
		->where('id_user',$request->id_usuario)->update(['texto'=>$request->comentario]);
		
        return $this->success($sets);
    }

    public function eliminar(Request $request){
        $data = Evaluacion::where('id_user',$request->id_usuario)
		->where('id_curso',$request->id_curso)
		->first();
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
		$id_evaluacion = $data->id;
		$set = Set::where('id_evaluacion',$id_evaluacion)->delete();
		$comentario = Comentario::where('id_user',$request->id_usuario)
		->where('id_curso',$request->id_curso)
		->first();
		$comentario->delete();
        $data->delete();
        return $this->success("Evaluacion eliminada");
    }
    public function listar(){
        $data = Evaluacion::get();
        return $this->success($data);
    }
    public function mostrar(Request $request){
        $data = Evaluacion::where('id_user',$request->id_usuario)
		->where('id_curso',$request->id_curso)
		->first();
		
        if(!$data) {
            return $this->response(["Objeto no encontrado"],200);
        }
		
		$id_evaluacion=$data->id;
		
		$set = Set::where('id_evaluacion',$id_evaluacion)
		->get();
		
        return $this->success($set);
    }

    public function porUsuario(Request $request){
        $data = Evaluacion::where('id_user',$request->id_user)
        ->where('id_curso',$request->id_curso)
		->first();
        if(!$data) {
            return $this->response(["Objeto no encontrado"],200);
        }
        return $this->success($data);
    }

    public function promedioProfesores(Request $request){
        $profesores = Profesor::get();
        $promedios = array();
        foreach ($profesores as $profesor) {
            $suma = Evaluacion::selectRaw('sum(calificacion) as suma')
            ->where('id_profesor',$profesor->id)
            ->get();
            $numero = Evaluacion::where('id_profesor',$profesor->id)
            ->count();
            $promedio = 0;
            if($numero>0)
                $promedio = $suma/$numero;
            array_push($promedios,['profesor'=>$profesor->nombre.' '.$profesor->ape_paterno,'promedio'=>$promedio,'id_profesor'=>$profesor->id]);
        }
        return $this->success($promedios);
    }

    public function promedioProfesor(Request $request){
        $profesor = Profesor::find($request->id);
        $suma = Evaluacion::selectRaw('sum(calificacion) as suma')
        ->where('id_profesor',$profesor->id)
        ->get();
        $numero = Evaluacion::where('id_profesor',$profesor->id)
        ->count();
        $promedio = 0;
        if($numero>0)
            $promedio = $suma/$numero;
        $promedios=['profesor'=>$profesor->nombre.' '.$profesor->ape_paterno,'promedio'=>$promedio,'id_profesor'=>$profesor->id];

        return $this->success($promedios);
    }

}
