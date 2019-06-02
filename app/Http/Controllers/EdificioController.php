<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Edificio;
class EdificioController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'nombre' => 'required',
            'id_campus' => 'required|exists:campus,id'
        ];
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $edificio = Edificio::create($datos);
        return $this->success($edificio);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Edificio::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Edificio::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(){
        $data = Edificio::get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Edificio::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }
}
