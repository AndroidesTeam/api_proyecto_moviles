<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comentario;
class ComentarioController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'texto' => 'required',
            'fecha' => 'required',
            'id_user' => 'required|exists:users,id',
            'id_curso' => 'required|exists:curso,id'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $comentario = Comentario::create($datos);
        return $this->success($comentario);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Comentario::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Comentario::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(){
        $data = Comentario::get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Comentario::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }

    public function obtenerComentariosPorProfesor(Request $request){
        $comentarios = Comentario::where('id_curso',$request->id_curso)->get();
        return $this->success($comentarios);
    }


    //no se usa
    public function obtenerComentarios(Request $request){
        $profesor= Profesor::find($request->id);
        $comentario = Comentario::where('id_profesor',$request->id)->get();
        $comentarios = ['profesor'=>$profesor->nombre.' '.$profesor->ape_paterno,'comentario'=>$comentario,'id_profesor'=>$profesor->id];
        return $this->success($comentarios);
    }
}
