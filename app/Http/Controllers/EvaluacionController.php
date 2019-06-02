<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evaluacion;
use App\Profesor;
use App\Comentario;
class EvaluacionController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'calificacion' => 'required',
            'fecha' => 'required',
            'id_user' => 'required|exists:user,id',
            'id_curso' => 'required|exists:curso,id'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $evaluacion = Evaluacion::create([
                'id_user'=>$request->id_usuario,
                'fecha'=>$request->fecha,
                'id_curso'=>$request->id_curso
            ]);
        $calificacion=0;
        foreach ($request->set as $set) {
            $respuesta = [
                'id_evaluacion'=>$evaluacion->id,
                'id_pregunta'=>$set->id_pregunta,
                'puntuacion'=>$set->calificacion
            ];
            App\Set::create($respuesta);
            $calificacion+= $set->calificacion;
        }
        $calificacion = $calificacion/count($request->set);
        $evaluacion->calificacion=$calificacion;
        $evaluacion->save();
        return $this->success($evaluacion);
    }

    public function obtenerPromedio(Request $request){
        $evaluaciones = Evaluacion::join('curso','id_evaluacion','=','evaluacion.id')
        ->where('id_profesor',$request->id_profesor);
        $suma=$evaluaciones->sum('calificacion');
        $promedio = $suma/$evaluaciones->count();

        $cuantos = $evaluaciones->count();
        /*$cuantos1 = $evaluaciones->where('calificacion',1)->count();
        $cuantos2 = $evaluaciones->where('calificacion',2)->count();
        $cuantos3 = $evaluaciones->where('calificacion',3)->count();
        $cuantos4 = $evaluaciones->where('calificacion',4)->count();*/
        $profesor = Profesor::find($request->id_profesor);
        $profesor->promedio = $promedio;
        /*$profesor->respuesta1= $cuantos1;
        $profesor->respuesta2= $cuantos2;
        $profesor->respuesta3= $cuantos3;
        $profesor->respuesta4= $cuantos4;*/
        $profesor->cuantos= $cuantos;

        $cont =1;
        $preguntas=array();
        while($cont < 9){
            $evaluacion = $this->porPregunta($cont,$request->id_profesor);
            $total_respuestas = $evaluacion->count();
            $total_uno= $evaluacion->where('set.puntuacion',1)->count();
            $total_dos= $evaluacion->where('set.puntuacion',2)->count();
            $total_tres= $evaluacion->where('set.puntuacion',3)->count();
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
    public function porPregunta($pregunta,$id_profesor){
        $evaluaciones= Evaluacion::join('curso','curso.id_evaluacion','=','evaluacion.id')
        ->join('set','set.id_evaluacion','=','evaluacion.id')
        ->where('id_profesor',$id_profesor)
        ->where('id_pregunta',$pregunta);

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
        $data = Evaluacion::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }

    public function eliminar($id){
        $data = Evaluacion::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(){
        $data = Evaluacion::get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Evaluacion::find($id);
        if(!$data) {
            return $this->response(["Objeto no encontrado"],200);
        }
        return $this->success($data);
    }

    public function porUsuario(Request $request){
        $data = Evaluacion::where('id_usuario',$request->id_usuario)
        ->where('id_curso',$request->id_curso)
        ->first();
        if(!$data) {
            return $this->response(["Objeto no encontrado"],200);
        }
        $comentario = Comentario::where('id_usuario',$request->id_usuario)->first();
        $data->evaluaciones = $data->set;
        $data->comentario = $comentario;
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
