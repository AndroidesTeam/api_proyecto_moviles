<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pregunta;

class PreguntaController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'pregunta' => 'required'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $pregunta = Pregunta::create($datos);
        return $this->success($pregunta);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Pregunta::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Pregunta::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(){
        $data = Pregunta::with('respuesta')->get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Pregunta::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }
}
