<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;

class CampusController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'nombre' => 'required',
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $campus = Campus::create($datos);
        return $this->success($campus);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Campus::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Campus::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(){
        $data = Campus::get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Campus::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }
}
