<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use App\votacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class votacionController extends Controller
{
    public function index()
    {
        $elecciones = votacion::GetEleccionesAct();
        return view('votacion')->with(array(
            'elecciones' => $elecciones
        ));
    }

    public function getPostulados(Request $request){
        $periodo = $request->input('periodo');
        $permiso = votacion::validateUser($periodo, Auth::user()->tipo, Auth::user()->id);
        if($permiso->count==0){
            return response()->json('<h1>No puedes votar en esta eleccion</h1>');
        }
        $permiso2 = votacion::validateVoto($periodo, Auth::user()->tipo, Auth::user()->id);
        if($permiso2){
            return response()->json('<h1 style="color: #2b542c;">Ya votaste en esta eleccion</h1>');
        }
        $postulados = votacion::GetPostulados($periodo, Auth::user()->tipo, Auth::user()->id_escuela);

        $output=<<<EOT
            <style>
                .card {
                    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                    transition: 0.3s;
                    width: 100%;
                }
                .card:hover {
                    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
                }
            </style>
EOT;

//dd($postulados);

        foreach($postulados as $postulado){
            $output.=<<<EOT
        <div class="col col-sm-3 postulado">
            <div class="card" style="text-align: center">
              <i class="fas fa-user-circle fa-10x"></i>
              <div class="">
                <h5>Nombre: <b>$postulado->nombre</b></h5> 
                <span>Cedula: <b>$postulado->cedula</b></span><br>
                <span>Cargo: <b>$postulado->nombre_cargo</b></span><br>
                <span>Votos: <b>$postulado->n_votos</b></span>
                <input type="hidden" value="$postulado->id_postulado" class="id_postulado">
                <input type="hidden" value="$postulado->id_cargos" class="id_cargo">
              </div>
            </div>
        </div>
EOT;
        }

        return response()->json($output);
    }


    public function getVoto(Request $request){
        $id_postulado = $request->input('id_postulado');
        $eleccion = $request->input('periodo');
        $id_cargo = $request->input('id_cargo');
        votacion::addVoto($id_postulado, Auth::user()->id, $eleccion, Auth::user()->tipo, $id_cargo);
        return response()->json('ok');
    }
}
