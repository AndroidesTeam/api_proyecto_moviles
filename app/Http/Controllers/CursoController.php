<?php

namespace App\Http\Controllers;
use App\Curso;

use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'id_materia' => 'required|exists:materia,id',
            'id_profesor' => 'required|exists:profesor,id'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $curso = Curso::create($datos);
        return $this->success($curso);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Curso::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Curso::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(){
        $data = Curso::get();
        return $this->success($data);
    }
    public function mostrar(Request $request){
        $data = Curso::where('id_profesor',$request->id_profesor)->where('id_materia',$id_materia)->fisrt();
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }
}
