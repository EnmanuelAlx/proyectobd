<?php

namespace App\Http\Controllers;

use App\CargoEleccion;
use App\ComisionElectoral;
use Illuminate\Http\Request;

class ComisionElectoralController extends Controller
{

    const MODEL = "ComisionElectoral";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cantidad = ComisionElectoral::cantidad();
        $profesores = ComisionElectoral::getProfesores();
        $egresados = ComisionElectoral::getEgresados();
        $elecciones = CargoEleccion::getElecciones();

        return view('ComisionElectoral')->with(array(
            'mod' => self::MODEL,
            'cantidad' => $cantidad,
            'header' => 'Comision Electoral',
            'profesores' => $profesores,
            'egresados' => $egresados,
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
        $inputs = $request->all();
        ComisionElectoral::addNew($inputs['eleccion'], array_merge($inputs['profesores'], $inputs['egresados']));
        return response()->json('ok');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = $request->input('query');
        $rows = ComisionElectoral::buscar($query);
        $output = <<<EOT
            <div class="list-group">
EOT;
        foreach($rows as $result){
            $output.=<<<EOT
            <div class="list-group-item">
                <a href="#" class="search-result" data-id="$result->cedula/$result->id_eleccion">$result->id_eleccion</a><br>
                <span>Nombre: <b>$result->nombre</b></span>
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
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->input('id');
        list($cedula, $eleccion) = explode( '/', $id);
        $record = ComisionElectoral::getItem($cedula, $eleccion);
        $output = <<<EOT
            <div>
            <table class="table">
               <tr>
               <th>Nombre</th>
               <th>Cedula</th>
               <th>Escuela</th>
               <th>Eleccion</th>
</tr>
            <tr>
            <td>$record->nombre</td>
            <td>V-$record->id</td>
            <td>$record->nombre_escuela</td>
            <td>$record->id_eleccion</td>
</tr>
</table>
               
            </div>
EOT;

        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */
    public function edit(Facultades $facultades)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('item_id');
        $inputs = $request->all();
        list($cedula, $eleccion) = explode( '/', $id);

        ComisionElectoral::editar($eleccion, array_merge($inputs['profesores'], $inputs['egresados']));
        return response()->json('hey');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facultades  $facultades
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        list($cedula, $eleccion) = explode( '/', $id);
        ComisionElectoral::borrar($cedula, $eleccion);
        return response()->json($id);
    }
}
