<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Postulaciones extends Model
{
    public $timestamps = true;

    public static $tabla= 'proceso_eleccion';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(id) from $tabla");
        return $cantidad[0]->count;
    }

    public static function cantidadProfesores(){
        return 1;
    }

    public static function cantidadEgresados(){
        return 1;
    }

    public static function buscar($query){
        $tabla = self::$tabla;
        $tipo = Auth::user()->tipo;
        $cedula = Auth::user()->id;
        if($tipo == 1){
            if(empty($query)){
                return DB::select("SELECT ep.id, ep.cedula, ep.n_votos, posee.id_eleccion, count(posee.id_cargos) as num_cargos
                                   FROM profesores_postulados as ep, posee
                                   WHERE ep.cedula=$cedula AND 
                                   posee.id_profesor_postulado = ep.id
                                   GROUP BY ep.id, ep.cedula, ep.n_votos, posee.id_eleccion");
            }
        }
        else{
            if(empty($query)){
                return DB::select("SELECT ep.id, ep.cedula, ep.n_votos,se_postulan.id_eleccion, count(se_postulan.id_cargos) as num_cargos
                                   FROM egresados_postulados as ep, se_postulan
                                   WHERE ep.cedula=$cedula AND 
                                   se_postulan.id_egresado_postulado = ep.id
                                   GROUP BY ep.id, ep.cedula, ep.n_votos, se_postulan.id_eleccion");
            }
        }


    }

    public static function addNew($eleccion, $cargos){
        $tabla = self::$tabla;
        $fecha = date("Y-m-d");
        $cedula = Auth::user()->id;
        $id_escuela = Auth::user()->id_escuela;
        if(Auth::user()->tipo==2){
            $return = DB::insert("INSERT INTO egresados_postulados (fecha_postulacion, cedula, n_votos, status) VALUES ('$fecha',$cedula, 0, 0)");
            $id = DB::select("SELECT (id) FROM egresados_postulados where cedula = $cedula and fecha_postulacion = '$fecha' ORDER BY id DESC");
            $id = $id[0]->id;
            foreach($cargos as $cargo){
//            dd($id, $cargo, $eleccion, $id_escuela);
                DB::insert("INSERT INTO se_postulan (id_egresado_postulado, id_cargos, id_eleccion, id_escuelas) 
                        VALUES($id, $cargo,'$eleccion', $id_escuela)");
            }
        }
        else{
            $return = DB::insert("INSERT INTO profesores_postulados (fecha_postulacion, cedula, n_votos, status) VALUES ('$fecha',$cedula, 0, 0)");
            $id = DB::select("SELECT (id) FROM profesores_postulados where cedula = $cedula and fecha_postulacion = '$fecha' ORDER BY id DESC");
            $id = $id[0]->id;
            foreach($cargos as $cargo){
//            dd($id, $cargo, $eleccion, $id_escuela);
                DB::insert("INSERT INTO posee (id_profesor_postulado, id_cargos, id_eleccion, id_escuelas) 
                        VALUES($id, $cargo,'$eleccion', $id_escuela)");
            }
        }
        return 1;
    }

    public static function borrar($id){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE id = '$id'");
    }

    public static function getItem($id, $tipo){
        $tabla = self::$tabla;
        if($tipo == 2){
            return DB::select("SELECT ep.id, ep.cedula, ep.n_votos,se_postulan.id_eleccion, cargos.nombre
                                   FROM egresados_postulados as ep, se_postulan, cargos
                                   WHERE ep.id = $id AND 
                                   se_postulan.id_egresado_postulado = ep.id AND 
                                   cargos.id=se_postulan.id_cargos");
        }
        return DB::select("SELECT pp.fecha_postulacion, pp.n_votos, sp.id_eleccion, cargos.nombre
                           FROM cargos, profesores_postulados as pp, posee as sp
                           WHERE sp.id_profesor_postulado = $id AND 
                                 pp.id = $id AND 
                                 cargos.id=sp.id_cargos");
    }

    public static function editar($id, $f_inicio, $f_fin, $fecha_limite_postulacion, $fecha_limite_votacion){
        $tabla = self::$tabla;
        DB::update("update $tabla set fecha_inicio = '$f_inicio', fecha_fin = '$f_fin', fecha_limite_postulacion = '$fecha_limite_postulacion', fecha_limite_votacion = '$fecha_limite_votacion' WHERE id = '$id'");
    }
}
