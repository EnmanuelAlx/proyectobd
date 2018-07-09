<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reporte;
use App\CargoEleccion;
use Barryvdh\DomPDF\Facade as PDF;
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
    //1 ya
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
<tbody>
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
            </tbody>
        </table>    
        <button class="btn btn-primary" id="pdf">Exportar PDF</button>    
EOT;
    return response()->json($output);
    }
    //2
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
        <button class="btn btn-primary" id="pdf">Exportar PDF</button> 
EOT;
    return response()->json($output);
    }
    //3 ya
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
                <button class="btn btn-primary" id="pdf">Exportar PDF</button>  
EOT;
            return response()->json($output);
    }
    //4 ya
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
        <button class="btn btn-primary" id="pdf">Exportar PDF</button> 
EOT;
    return response()->json($output);
    }

    //1
    public function printPdfCargos_eleccion(Request $request){
        $eleccion = $request->input('id_eleccion');
        $tabla = $this->cargos_eleccion($eleccion);
        $pdf = PDF::loadHTML($tabla);
        return $pdf->download('reporte.pdf');
    }
    //4
    public function printPdfEgresadosUnoMasCargos(Request $request){
        $eleccion = $request->input('id_eleccion');
        $tabla = $this->EgresadosUnoMasCargos($eleccion);
        $pdf = PDF::loadHTML($tabla);
        return $pdf->download('reporte.pdf');
    }
    //3
    public function printPdftotal_post_prof(Request $request){
        $eleccion = $request->input('id_eleccion');
        $tabla = $this->votoPorfPDF($eleccion);
        $pdf = PDF::loadHTML($tabla);
        return $pdf->download('reporte.pdf');
    }
    //2
    public function printPdftotal_post_egre(Request $request){
        $eleccion = $request->input('id_eleccion');
        $tabla = $this->VotoEgresadoPDF($eleccion);
        $pdf = PDF::loadHTML($tabla);
        return $pdf->download('reporte.pdf');
    }

    public function cargos_eleccion($eleccion){
        $cargosEleccion=Reporte::getCargosEleccion($eleccion);

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
<tbody>
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
            </tbody>
        </table>    
        <button class="btn btn-primary" id="pdf">Exportar PDF</button>    
EOT;
        return $output;
    }

    public function EgresadosUnoMasCargos($eleccion){
        $cargosEleccion=Reporte::getpostmas1egre($eleccion);
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
        return $output;
    }

    public function votoPorfPDF($eleccion){
        $cargosEleccion=Reporte::getVotosProfesores($eleccion);

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
        return $output;
    }

    public function VotoEgresadoPDF($eleccion){
        $cargosEleccion=Reporte::getVotosEgresados($eleccion);
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
        return $output;
    }
}

