<?php

namespace App\Http\Controllers;

use App\Extensiones;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExtensionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cantidad = Extensiones::cantidad();
        return view('extensiones')->with(array(
            'mod' => 'extensiones',
            'cantidad' => $cantidad,
            'header' => 'Extensiones'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->input('id');
        $nombre = $request->input('nombre');
        Extensiones::addNew($nombre);
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
        $nombre = $request->input('nombre');
        $rows = Extensiones::buscar($query,$nombre);
        $output = <<<EOT
            <div class="list-group">
EOT;
        foreach($rows as $result){
            $output.=<<<EOT
            <div class="list-group-item">
                <a href="#" class="search-result" data-id="$result->id">$result->nombre</a><br>
                
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
        $record = Extensiones::getItem($id);

        $output = <<<EOT
            <div>
                <span>Extension: <b>$record->nombre</b></span><br>
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
        $nombre = $request->input('nombre');
       
        Extensiones::editar($id, $nombre);
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
        Extensiones::borrar($id);
        return response()->json($id);
    }
}
