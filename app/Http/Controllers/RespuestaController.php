<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respuesta;
class RespuestaController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'id_pregunta' => 'required|exists:pregunta,id',
            'respuesta' => 'required',
            'valor'=>'required'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $respuesta = Respuesta::create($datos);
        return $this->success($respuesta);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Respuesta::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Respuesta::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(){
        $data = Respuesta::get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Respuesta::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }
}
