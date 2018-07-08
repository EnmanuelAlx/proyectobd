<?php

namespace App\Http\Controllers;

use App\CargoEleccion;
use App\User;
use App\votacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CargoEleccionController extends Controller
{
    const MODEL = 'CargoEleccion';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cantidad = CargoEleccion::cantidad();
        $cargos = CargoEleccion::getCargos();
        $elecciones = array('id' => 0);
        if(Auth::user()->id == 1){
            $elecciones = CargoEleccion::getElecciones();
        }
        else if(User::verificarComison(Auth::user()->id)){
            $elecciones = CargoEleccion::GetEleccionesAct();
        }
        $escuelas = CargoEleccion::getEscuelas();
        return view('cargos_x_eleccion')->with(array(
            'mod' => self::MODEL,
            'cantidad' => $cantidad,
            'header' => 'Cargos por Eleccion',
            'cargos' => $cargos,
            'elecciones' => $elecciones,
            'escuelas' => $escuelas
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $inputs = $request->all();
        foreach($inputs['cargos'] as $cargo){
            CargoEleccion::addNew($inputs['eleccion'], $cargo, $inputs['escuela']);
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
        $rows = CargoEleccion::buscar($query);
        $output = <<<EOT
            <div class="list-group">
EOT;
        foreach($rows as $result){
            $output.=<<<EOT
            <div class="list-group-item">
                <a href="#" class="search-result" data-id="$result->id_escuela/$result->eleccion">$result->eleccion</a><br>
                <span>Escuela: $result->escuelas</span><br>
                <span>Cantidad de Cargos <b>$result->count</b></span>
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
        list($id_escuela, $id_eleccion) = explode('/',$id);
        $record = CargoEleccion::getItem($id_escuela, $id_eleccion);
        $escuela_lbl = $record[0]->nombre;
        $id_eleccion_lbl = $record[0]->id;
        $output = <<<EOT
            <div>
                <span>Cargos: </span><br>
EOT;
        foreach($record as $row){
            $output.=<<<EOT
                <span><b>$row->cargo</b></span><br>  
EOT;
        }
        $output .= <<<EOT
                <span>Escuela: <b>$escuela_lbl</b></span><br>
                <span>Eleccion: <b>$id_eleccion_lbl</b></span><br>     
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
        $id = $request->input('item_id');
        list($id_escuela, $id_eleccion) = explode('/',$id);
        $cargos = $request->input('cargos');

        CargoEleccion::editar($id_escuela, $id_eleccion, $cargos);
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
        list($id_escuela, $id_eleccion) = explode('/',$id);

        CargoEleccion::borrar($id_escuela, $id_eleccion);
        return response()->json($id);
    }
}
