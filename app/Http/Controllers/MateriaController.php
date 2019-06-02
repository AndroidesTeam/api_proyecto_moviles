<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Materia;
class MateriaController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'nombre' => 'required'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $materia = Materia::create($datos);
        return $this->success($materia);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Materia::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Materia::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(Request $request){
        $data = Materia::where('semestre',$request->semestre)->get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Materia::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }


}
