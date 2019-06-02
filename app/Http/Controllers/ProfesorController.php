<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesor;
class ProfesorController extends Controller
{
    public function insertar(Request $request){
        $rules = [
            'nombre' => 'required',
            'ap_paterno' => 'required'
        ];

        
        $datos = $request->all();
        $errores = $this->validate($datos,$rules);
        if(count($errores)>0){
            return $this->error($errores);
        }
        $profesor = Profesor::create($datos);
        if(isset($request->foto)){
            $image = $request->file('foto');
            $nombre['imagename']= $profesor->id.'.'.$image->getClientOriginalExtension();
            $path = public_path('/storage/app/public/');
            $image->move($path,$nombre['imagename']);
            $profesor->foto = '/storage/app/public/'.$nombre['imagename'];
            $profesor->save();
        }
        return $this->success($profesor);
    }
    public function actualizar(Request $request){
        $array = $request->all();
        $data = Profesor::find($request->id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        $data->update($array);
        return $this->success($data);
    }
    public function eliminar($id){
        $data = Profesor::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }

        $data->delete();
        return $this->succes(["objeto eliminado correctamente"]);
    }
    public function listar(Request $request){
        $data = Profesor::join('curso','id_profesor','=','profesor.id')
        ->where('id_materia',$request->id_materia)->get();
        return $this->success($data);
    }
    public function mostrar($id){
        $data = Profesor::find($id);
        if(!$data) {
            return $this->error(["Objeto no encontrado"]);
        }
        return $this->success($data);
    }
}
