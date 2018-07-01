<?php

namespace App\Http\Controllers;

use App\Escuelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EscuelasController extends Controller
{
    const MODEL = 'escuelas';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cantidad = Escuelas::cantidad();
        $facultades = Escuelas::getFacultades();
        $extensiones = Escuelas::getExtensiones();
        return view('escuelas')->with(array(
            'mod' => self::MODEL,
            'cantidad' => $cantidad,
            'header' => 'Escuelas',
            'facultades' => $facultades,
            'extensiones' => $extensiones
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $nombre = $request->input('nombre');
        $id_facultad =$request->input('facultades');
        $id_extension =$request->input('extensiones');
        Escuelas::addNew($nombre,$id_facultad,$id_extension);
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
        $rows = Escuelas::buscar($query);

        $output = <<<EOT
            <div class="list-group">
EOT;
        foreach($rows as $result){
            $output.=<<<EOT
            <div class="list-group-item">
                <a href="#" class="search-result" data-id="$result->id">
                    <span>Escuela: <b>$result->nombre_escuela</b></span><br>
                    <span>Extension: <b>$result->nombre_extension</b></span>
                </a>
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
        $record = Escuelas::getItem($id);
        $output = <<<EOT
            <div>
                <span>Escuela: <b>$record->nombre_escuela</b></span><br>
                <span>Facultad: <b>$record->nombre_facultad</b></span><br>
                <span>Extension: <b>$record->nombre_extension</b></span>
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
        $nombre = $request->input('nombre');
        $facultad = $request->input('facultades');
        $extension = $request->input('extensiones');
        Escuelas::editar($id,$nombre,$facultad,$extension);
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
        Escuelas::borrar($id);
        return response()->json($id);
    }
}
