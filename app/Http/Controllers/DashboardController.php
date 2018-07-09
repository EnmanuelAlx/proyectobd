<?php

namespace App\Http\Controllers;

use App\CargoEleccion;
use App\ProcesoEleccion;
use App\votacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        $eleccion = votacion::GetEleccionesAct();
        $elecciones = CargoEleccion::getElecciones();
        $chart1 = $this->getChartEgresados($eleccion);
        $chart2 = $this->getChartProfesores($eleccion);



        return view('dashboard')->with(array(
            'elecciones' => $elecciones,
            'grafico_profesores' => $chart1,
            'grafico_egresados' => $chart2
        ));
    }
    public function getChartEgresados($eleccion){
        $egresados_postulados = votacion::getVotosEgresados($eleccion[0]->id);
        $nombre_egresados_postulados = array();
        $votos_egresados_postulados = array();
        $nombre_cargos_egresados_postulados = array();
        $nombre_cargo = array();

        foreach($egresados_postulados as $egresado){
            array_push($nombre_egresados_postulados, $egresado->nombre_egresado);
            array_push($votos_egresados_postulados, $egresado->n_votos);
            array_push($nombre_cargos_egresados_postulados, $egresado->nombre);
        }

        foreach($nombre_egresados_postulados as $key => $egresado){
            array_push($nombre_cargo, $egresado.'<br>'.$nombre_cargos_egresados_postulados[$key]);
        }

        return $chart1 = \Chart::title([
            'text' => 'Elecciones '.$eleccion[0]->fecha_inicio.'/'.$eleccion[0]->fecha_limite_votacion,
        ])
            ->chart([
                'type'     => 'column', // pie , columnt ect
                'renderTo' => 'egresados', // render the chart into your div with id
            ])
            ->subtitle([
                'text' => 'Resultados de las elecciones para egresados',
            ])
            ->colors([
                '#c13f3f',
            ])
            ->xaxis([
                'categories' => $nombre_cargo,
                'labels'     => [
                    'rotation'  => 0,
                    'align'     => 'center',
                    'formatter' => "",
                ],
            ])
            ->yaxis([
                'text' => 'HOLA',
            ])
            ->legend([
                'layout'        => 'vertikal',
                'align'         => 'right',
                'verticalAlign' => 'middle',
            ])
            ->series(
                [
                    [
                        'name'  => 'Votos',
                        'data'  => $votos_egresados_postulados,
                        'color' => '#c91c36',
                    ],
                ]
            )
            ->display();

    }
    public function getChartProfesores($eleccion){
        $profesores_postulados = votacion::getVotosProfesores($eleccion[0]->id);
        $nombre_profesores_postulados = array();
        $votos_profesores_postulados = array();
        $nombre_cargos_profesor_postulado = array();
        $nombre_cargo = array();
        foreach ($profesores_postulados as $profesor) {
            array_push($nombre_profesores_postulados, $profesor->nombre_profesor);
            array_push($votos_profesores_postulados, $profesor->n_votos);
            array_push($nombre_cargos_profesor_postulado, $profesor->nombre);
        }

        foreach($nombre_profesores_postulados as $key => $profesor){
            array_push($nombre_cargo, $profesor.'<br>'.$nombre_cargos_profesor_postulado[$key]);
        }

        return $chart1 = \Chart::title([
            'text' => 'Elecciones '.$eleccion[0]->fecha_inicio.'/'.$eleccion[0]->fecha_limite_votacion,
        ])
            ->chart([
                'type'     => 'column', // pie , columnt ect
                'renderTo' => 'profesores', // render the chart into your div with id
            ])
            ->subtitle([
                'text' => 'Resultados de las elecciones para profesores',
            ])
            ->colors([
                '#c13f3f',
            ])
            ->xaxis([
                'categories' => $nombre_cargo,
                'labels'     => [
                    'rotation'  => 0,
                    'align'     => 'center',
                    'formatter' => "",
                ],
            ])
            ->yaxis([
                'text' => 'HOLA',
            ])
            ->legend([
                'layout'        => 'vertikal',
                'align'         => 'right',
                'verticalAlign' => 'middle',
            ])
            ->series(
                [
                    [
                        'name'  => 'Votos',
                        'data'  => $votos_profesores_postulados,
                        'color' => '#2d41a8',
                    ],
                ]
            )
            ->display();

    }


    public function getGraficas(Request $request){
        $id_eleccion = $request->input('id_eleccion');
        $eleccion = ProcesoEleccion::getEleccion($id_eleccion);
        $chart1 = $this->getChartProfesores($eleccion);
        $chart2 = $this->getChartEgresados($eleccion);

        return response()->json([
            'grafica_profesores' => $chart1,
            'grafica_egresados' => $chart2
        ]);

    }


}
