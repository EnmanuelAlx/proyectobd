<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reporte extends Model
{
    public static function getCargosEleccion($elecion){
      return  DB::select("SELECT elect.id, car.nombre
        FROM proceso_elecciones AS elect, cargos AS car, cargos_por_elecciones as ce
        WHERE elect.id = '$elecion' 
        AND ce.id_eleccion = elect.id
        AND car.id = ce.id_cargos");       
    }
    public static function getVotosEgresados($eleccion){
        return  DB::select("SELECT usu.id, usu.nombre, car.nombre as cargo, sp.n_votos 
        FROM usuarios AS usu,cargos AS car,proceso_elecciones AS pe,cargos_por_elecciones AS ce, se_postulan as sp, extensiones AS ext, egresados_postulados as pp
        WHERE pe.id = '$eleccion' 
        and ce.id_eleccion = pe.id 
        and car.id = ce.id_cargos 
        and sp.id_eleccion = ce.id_eleccion 
        and pp.id = sp.id_egresado_postulado 
        and usu.id = pp.cedula 
        AND sp.id_cargos = car.id
        order by car.nombre, sp.n_votos");       
      }
    public static function getVotosProfesores($elecion){
        return  DB::select("SELECT usu.id, usu.nombre, car.nombre as cargo, pos.n_votos 
        FROM usuarios AS usu,cargos AS car,proceso_elecciones AS pe,cargos_por_elecciones AS ce, posee AS pos, extensiones AS ext, profesores_postulados as pp
        WHERE pe.id = '$elecion' 
        and ce.id_eleccion = pe.id 
        and car.id = ce.id_cargos 
        and pos.id_eleccion = ce.id_eleccion 
        and pp.id = pos.id_profesor_postulado 
        and usu.id = pp.cedula 
        AND pos.id_cargos = car.id
        order by car.nombre, pos.n_votos");       
      }
      public static function getpostmas1($elecion){
        return  DB::select("SELECT usu.id, usu.nombre, car.nombre as cargo, count( car.id) AS cantidadCargos
        FROM usuarios AS usu,cargos AS car,proceso_elecciones AS pe,cargos_por_elecciones AS ce, posee AS pos, extensiones AS ext, profesores_postulados as pp
        WHERE pe.id = '$elecion' and
        ce.id_eleccion = pe.id and
        car.id = ce.id_cargos and
        pos.id_eleccion = ce.id_eleccion and
        pp.id = pos.id_profesor_postulado and
        usu.id = pp.cedula and
        pos.id_cargos = car.id
        group by usu.nombre,car.nombre,usu.id_extension,usu.id
        having count(car.nombre) >=2
        order by usu.id_extension, usu.id");       
      }  
      public static function getpostmas1egre($elecion){
        return  DB::select("SELECT usu.id, usu.nombre, car.nombre as cargo, count( car.id) AS cantidadCargos
        FROM usuarios AS usu,cargos AS car,proceso_elecciones AS pe,cargos_por_elecciones AS ce, se_postulan AS sp, extensiones AS ext, egresados_postulados as pp
        WHERE pe.id = '$elecion' and
        ce.id_eleccion = pe.id and
        car.id = ce.id_cargos and
        sp.id_eleccion = ce.id_eleccion and
        pp.id = sp.id_egresado_postulado and
        usu.id = pp.cedula and
        sp.id_cargos = car.id
        group by usu.nombre,car.nombre,usu.id_extension,usu.id
        having count(car.nombre) >=2
        order by usu.id_extension, usu.id");       
      } 
}
