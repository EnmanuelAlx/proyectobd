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
    public static function GetPostuladosAct(){
        return DB::select("select usu.nombre as nombreU, c.nombe as nombreCs
                           from usuarios as usu, cargos as c, profesores as p, profesores_postulados as pp,
                                posee as pos, proceso_elecciones as pe
                           where (fecha inicio) = pe.fecha_inicio and (fecha fin) = pe.fecha_limite_votacion and
                                 pos.id_eleccion = pe.id and c.id = pos.id_cargos and pp.id = pos.id_profesor_postulado and
                                 p.id = pos.id and usu.id = p.id");     
    }
}

