<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reporte;
use App\CargoEleccion;

class reportesController extends Controller
{
    public function reporteCargosEleccion(){
        $elecciones=CargoEleccion::getElecciones();
        return view('reportes.cargos_eleccion')->with(array( 
            'elecciones' => $elecciones
        ));   


    }
    public function getVotosEgresados(){
        $elecciones=CargoEleccion::getElecciones();
        return view('reportes.total_post_egre')->with(array( 
            'elecciones' => $elecciones
        )); 
    }

    public function getVotosProfesores(){
        $elecciones=CargoEleccion::getElecciones();
        return view('reportes.total_post_prof')->with(array( 
            'elecciones' => $elecciones
        )); 
    }

    public function getpostmas1(){
        $elecciones=CargoEleccion::getElecciones();
        return view('reportes.post_prof_1mas_cargos')->with(array( 
            'elecciones' => $elecciones
        )); 
    }

    public function getpostmas1egre(){
        $elecciones=CargoEleccion::getElecciones();
        return view('reportes.post_egre_1mas_cargos')->with(array( 
            'elecciones' => $elecciones
        )); 
    }

    public function electget(Request $request){
        $cargosEleccion=Reporte::getCargosEleccion($request->input('periodo'));
    
        $output = <<<EOT
        <table class='table'>
            <tr>
                <th>
                    Eleccion
                </th>
                <th>
                    Cargo
                </th>
            </tr>
EOT;
    foreach($cargosEleccion as $row){
    $output .= <<<EOT
    <tr>
        <td>
            $row->id
        </td>
        <td>
            $row->nombre
        </td>
    </tr>    
EOT;

    }
$output .= <<<EOT
        
        </table>        
EOT;
    return response()->json($output);
    }
    




public function eleccttget(Request $request){
    $cargosEleccion=Reporte::getVotosEgresados($request->input('periodo'));
    $output = <<<EOT
    <table class='table'>
        <tr>
            <th>
                Cedula
            </th>
            <th>
                Nombre
            </th>
            <th>
                Cargo
            </th>
            <th>
                Votos
            </th>
        </tr>
EOT;
foreach($cargosEleccion as $row){
$output .= <<<EOT
<tr>
    <td>
        $row->id
    </td>
    <td>
        $row->nombre
    </td>
    <td>
        $row->cargo
    </td>
    <td>
        $row->n_votos
    </td>
</tr>    
EOT;

}
$output .= <<<EOT
    
    </table>        
EOT;
return response()->json($output);
}

public function votoProf(Request $request){
    $cargosEleccion=Reporte::getVotosProfesores($request->input('periodo'));
    $output = <<<EOT
    <table class='table'>
        <tr>
            <th>
                Cedula
            </th>
            <th>
                Nombre
            </th>
            <th>
                Cargo
            </th>
            <th>
                Votos
            </th>
        </tr>
EOT;
foreach($cargosEleccion as $row){
$output .= <<<EOT
<tr>
    <td>
        $row->id
    </td>
    <td>
        $row->nombre
    </td>
    <td>
        $row->cargo
    </td>
    <td>
        $row->n_votos
    </td>
</tr>    
EOT;

}
$output .= <<<EOT
    
    </table>        
EOT;
return response()->json($output);
}

public function elget1(Request $request){
    $cargosEleccion=Reporte::getpostmas1egre($request->input('periodo'));
    $output = <<<EOT
    <table class='table'>
        <tr>
            <th>
                Cedula
            </th>
            <th>
                Nombre
            </th>
            <th>
                Cargo
            </th>
            <th>
                Numero De Cargos Postulados
            </th>
        </tr>
EOT;
foreach($cargosEleccion as $row){
$output .= <<<EOT
<tr>
    <td>
        $row->id
    </td>
    <td>
        $row->nombre
    </td>
    <td>
        $row->cargo
    </td>
    <td>
        $row->cantidadCargoss
    </td>
</tr>    
EOT;

}
$output .= <<<EOT
    
    </table>        
EOT;
return response()->json($output);
}

}

