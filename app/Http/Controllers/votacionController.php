<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use App\votacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class votacionController extends Controller
{
    public function index()
    {
        $votantes=votacion::GetEleccionesAct(); 
        return view('votacion')->with(array(
                                'votacion' => $votantes
                            ));         
    }
    public function GetPostuladosAct(){
        $postulados=votacion::GetEleccionesAct(); 
        return view('votacion')->with(array(
                                'postulados' => $postulados
                            ));    
    }
}
