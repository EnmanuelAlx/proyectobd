<?php

namespace App\Http\Controllers;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class CargoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = Cargo::cantidad();
        return view('cargos')->with(array(
            'mod' => 'cargos',
            'cantidad' => $count,
            'header' => 'Cargos'
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
        $tipo = $request->input('tipo');
        Cargo::addNew($nombre, $tipo);
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
        $tipo = $request->input('tipo');
        $rows = Cargo::buscar($query, $tipo);

        $cargos = <<<EOT
            <div class="list-group">
EOT;
        
        foreach($rows as $result){
            $cargos.=<<<EOT
            <a href="#" class="list-group-item search-result" data-id="$result->id">$result->nombre</a>
EOT;
        }
        $cargos.=<<<EOT
            </div>
EOT;

        return response()->json($cargos);
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
        $record = Cargo::getItem($id);
//        dd($record);
        $output = <<<EOT
            <div>
                <b>Nombre</b> : <span>$record->nombre</span><br>
EOT;
        if($record->tipo==0){
            $output.=<<<EOT
               <b>Tipo</b> : <span>Cargo para Profesor</span>
EOT;
        }
        elseif($record->tipo==1){
            $output.=<<<EOT
               <b>Tipo</b> : <span>Cargo para Egresados</span>
EOT;
        }
        else{
            $output.=<<<EOT
                <b>Tipo</b> : <span>Cargo comun</span>
EOT;
        }


        return response()->json($output);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit(Cargo $cargo)
    {
        //
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
        $tipo = $request->input('tipo');
        Cargo::editar($id, $nombre, $tipo);
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
        Cargo::borrar($id);
        return response()->json($id);
    }
}
