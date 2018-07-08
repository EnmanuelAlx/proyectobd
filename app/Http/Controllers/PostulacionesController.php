<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Postulaciones;
use App\CargoEleccion;
use App\Cargo;
use Illuminate\Support\Facades\Auth;


class PostulacionesController extends Controller
{

    const MODEL = 'Postulaciones';

    public function index(){
        $countProfesores = Postulaciones::cantidadProfesores();
        $countEgresados = Postulaciones::cantidadEgresados();
        $count = $countProfesores+$countEgresados;
        $elecciones = CargoEleccion::getElecciones();
        $cargos = Cargo::getCargos();
        return view('postulaciones')->with(array(
            'mod' => self::MODEL,
            'cantidad' => $count,
            'header' => 'Postularse',
            'elecciones' => $elecciones,
            'cargos' => $cargos
        ));
    }



    public function create(Request $request)
    {
        $inputs = $request->all();
        Postulaciones::addNew($inputs['eleccion'], $inputs['cargos']);
        return response()->json('ok');
    }






    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Muestra el resultado de la busqueda
    public function store(Request $request)
    {
        $query = $request->input('query');
        $rows = Postulaciones::buscar($query);
        $nombre = Auth::user()->nombre;

        $output = <<<EOT
            <div class="list-group">
EOT;
        foreach($rows as $result){
            $output.=<<<EOT
            <div class="list-group-item">
                <a href="#" class="search-result" data-id="$result->id">$nombre</a><br>
                <span>Eleccion <b>$result->id_eleccion</b></span><br>
                <span>Nº Votos <b>$result->n_votos</b></span><br>
                <span>Nº Cargos <b>$result->num_cargos</b></span>
            </div>
EOT;
        }
        $output.=<<<EOT
            </div>
EOT;

        return response()->json($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');

        $record = Postulaciones::getItem($id, Auth::user()->tipo);
        $nombre = Auth::user()->nombre;
        $cedula = Auth::user()->id;
        $n_votos = $record[0]->n_votos;
        $eleccion = $record[0]->id_eleccion;

        $output = <<<EOT
        <table class="table">
            <tr>
                <td>
                    <span>Usuario: </span>
                </td>
                <td>
                    <b>$nombre</b>
                </td>
            </tr>
            <tr>
                <td>
                    <span>Cedula: </span>
                </td>
                <td>
                    <b>$cedula</b>
                </td>
            </tr>
            <tr>
                <td>
                    <span>Eleccion: </span>
                </td>
                <td>
                    <b>$eleccion</b>
                </td>
            </tr>
            <tr>
                <td>
                    <span>Nº Votos: </span>
                </td>
                <td>
                    <b>$n_votos</b>
                </td>
            </tr>
            <tr>
                <td>
                    <span>Cargos: </span>
                </td>
                <td>                            
EOT;
            foreach($record as $row){
                $output.=<<<EOT
                <span>$row->nombre</span><br>
EOT;
            }
        $output.=<<<EOT
                </td>
            </tr>
            
        </table> 
EOT;


        return response()->json($output);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('item_id');
        $f_inicio = $request->input('f_inicio');
        $f_fin = $request->input('f_fin');
        $fecha_limite_postulacion = $request->input('fecha_limite_postulacion');
        $fecha_limite_votacion = $request->input('fecha_limite_votacion');
        ProcesoEleccion::editar($id, $f_inicio, $f_fin, $fecha_limite_postulacion, $fecha_limite_votacion);
        return response()->json('hey');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $id = $request->input('id');
        ProcesoEleccion::borrar($id);
        return response()->json($id);
    }


    public function getCargos(Request $request)
    {
        $id_eleccion = $request->input('eleccion');
        $validate = Postulaciones::validateComisionElectoral($id_eleccion, Auth::user()->id);
        if($validate==1){
            return response()->json('err.comision');
        }
        $cargos = CargoEleccion::getItemWithTipo(Auth::user()->id_escuela, $id_eleccion, Auth::user()->tipo);
        if(empty($cargos)){
            return response()->json('err');
        }

        $output =<<<EOF
<table class="table">
<tr>
    <th>Cargos</th>
    <th></th>
</tr>
EOF;
        foreach($cargos as $cargo){
            $output.=<<<EOF
               <tr>
               <td> 
                   <span><b>$cargo->cargo</b></span>
               </td>
               <td>
               <input type="checkbox" name="cargos[]" value="$cargo->id_cargo">
</td>
</tr>
EOF;
        }

        $output.=<<<EOF
        </table>
EOF;
        return response()->json($output);
    }

}
