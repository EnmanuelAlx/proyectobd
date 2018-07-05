<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EgresadosVotantes extends Model
{
    public $timestamps = true;

    public static $tabla= 'egresados_votantes';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(*) from $tabla");
        return $cantidad[0]->count;
    }

    public static function getEgresados(){
        return DB::select("SELECT egresados.id, usuarios.nombre FROM egresados, usuarios WHERE egresados.id = usuarios.id");
    }

    public static function buscar($query){
        $tabla = self::$tabla;
        if(empty($query)){
            return DB::select("SELECT id_eleccion, count(cedula_egresado) as cantidad_profesores from $tabla GROUP BY id_eleccion");
        }

    }

    public static function addNew($eleccion, $egresado){
        $tabla = self::$tabla;
        $return = DB::insert("INSERT INTO $tabla (id_eleccion, cedula_egresado) VALUES ('$eleccion',$egresado)");
        return 1;
    }

    public static function borrar($id_eleccion){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE id_eleccion = '$id_eleccion'");
    }

    public static function getItem($eleccion){
        $tabla = self::$tabla;
        return DB::select("SELECT usuarios.id as cedulas,usuarios.nombre as nombres, pv.id_eleccion as eleccion
                           FROM usuarios, egresados_votantes as pv
                           WHERE pv.id_eleccion = '$eleccion' and
	                       pv.cedula_egresado = usuarios.id");
    }

    public static function editar($id_escuela, $id_eleccion, $cargos){
        return;
    }
}
