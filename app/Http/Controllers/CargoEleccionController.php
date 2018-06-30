<?php

namespace App\Http\Controllers;

use App\CargoEleccion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $elecciones = CargoEleccion::getElecciones();
        return view('cargos_x_eleccion')->with(array(
            'mod' => self::MODEL,
            'cantidad' => $cantidad,
            'header' => 'Cargos por Eleccion',
            'cargos' => $cargos,
            'elecciones' => $elecciones
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $eleccion = $request->input('eleccion');

//        ProcesoEleccion::addNew();
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
        $rows = ProcesoEleccion::buscar($query);
        $output = <<<EOT
            <div class="list-group">
EOT;
        foreach($rows as $result){
            $output.=<<<EOT
            <div class="list-group-item">
                <a href="#" class="search-result" data-id="$result->id">$result->id</a><br>
                <span>Fecha de inicio <b>$result->fecha_inicio</b></span><br>
                <span>Fecha de fin <b>$result->fecha_fin</b></span>
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
        $record = ProcesoEleccion::getItem($id);

        $output = <<<EOT
            <div>
                <span>Eleccion: <b>$record->id</b></span><br>
                <span>Fecha de Inicio: <b>$record->fecha_inicio</b></span><br>
                <span>Fecha de Finalizacion: <b>$record->fecha_fin</b></span><br>
                <span>Fecha limite de postulacion: <b>$record->fecha_limite_postulacion</b></span><br>
                <span>Fecha limite de Votacion: <b>$record->fecha_limite_votacion</b></span>
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
        $id = $request->input('id');
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
}
