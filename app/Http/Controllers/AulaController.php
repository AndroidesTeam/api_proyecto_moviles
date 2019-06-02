<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aula;

class AulaController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'nombre' => 'required',
            'id_edificio' => 'required|exists:edificio,id'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $aula = Aula::create($datos);
        return $this->success($aula);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Aula::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Aula::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(){
        $data = Aula::get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Aula::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }
}
