<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use App\votacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class votacionController extends Controller
{
    public static $tabla= 'proceso_elecciones';
    public function index()
    {
        $tabla = self::$tabla;
        $votantes=votacion::GetEleccionesAct(); 
        return view('votacion')->with(array(
                                'votacion' => $votantes
                            ));         
    }
    public function getPostulados(){
        dd('hola');
    }
}
