<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class votacion extends Model
{
    public static function GetEleccionesAct(){
        return DB::select("select pe.id, pe.fecha_inicio,pe.fecha_limite_votacion 
        from proceso_elecciones as pe
        where (select current_date) between pe.fecha_inicio and pe.fecha_fin");

        
    }
}
