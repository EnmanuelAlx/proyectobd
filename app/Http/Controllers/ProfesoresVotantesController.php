<?php

namespace App\Http\Controllers;

use App\CargoEleccion;
use App\ProfesoresVotantes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfesoresVotantesController extends Controller
{

    const MODEL = 'ProfesoresVotantes';

    public function index()
    {
        $cantidad = ProfesoresVotantes::cantidad();
        $profesores = ProfesoresVotantes::getProfesores();
        $elecciones = array('id' => 0);
        if(Auth::user()->id == 1){
            $elecciones = CargoEleccion::getElecciones();
        }
        else if(User::verificarComison(Auth::user()->id)){
            $elecciones = CargoEleccion::GetEleccionesAct();
        }
        return view('profesoresVotantes')->with(array(
            'mod' => self::MODEL,
            'cantidad' => $cantidad,
            'header' => 'Profesores Votantes',
            'profesores' => $profesores,
            'elecciones' => $elecciones
        ));
    }

    public function create(Request $request)
    {
        $inputs = $request->all();
        foreach($inputs['profesores'] as $profesor){
            ProfesoresVotantes::addNew($inputs['eleccion'], $profesor);
        }
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
        $rows = ProfesoresVotantes::buscar($query);
        $output = <<<EOT
            <div class="list-group">
EOT;
        foreach($rows as $result){
            $output.=<<<EOT
            <div class="list-group-item">
                <a href="#" class="search-result" data-id="$result->id_eleccion">$result->id_eleccion</a><br>              
                <span>Cantidad de Profesores Votantes <b>$result->cantidad_profesores</b></span>
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
        $eleccion = $request->input('id');
        $record = ProfesoresVotantes::getItem($eleccion);
        $eleccion_lbl = $record[0]->eleccion;
        $output = <<<EOT
            <div>
                <span>Eleccion: $eleccion_lbl</span><br>
                <span>Profesores: </span><br>
<hr>
    <table class="table">
    <tr>
    <th>Cedula</th>
    <th>Nombre</th>
</tr>
EOT;
        foreach($record as $row){
            $output.=<<<EOT
            <tr>
            <td>$row->cedulas</td>
            <td>$row->nombres</td>
</tr>
                
EOT;
        }
        $output .= <<<EOT
        </table>
            </div>
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
        $id_eleccion = $request->input('id');
        ProfesoresVotantes::borrar($id_eleccion);
        return response()->json($id_eleccion);
    }
}
