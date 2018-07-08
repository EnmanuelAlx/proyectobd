<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProfesoresVotantes extends Model
{
    public $timestamps = true;

    public static $tabla= 'profesores_votantes';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(*) from $tabla");
        return $cantidad[0]->count;
    }

    public static function getProfesores(){
        return DB::select("SELECT profesores.id, usuarios.nombre FROM profesores, usuarios WHERE profesores.id = usuarios.id");
    }

    public static function buscar($query){
        $tabla = self::$tabla;
        if(empty($query)){
            return DB::select("SELECT id_eleccion, count(cedula_profesor) as cantidad_profesores from $tabla GROUP BY id_eleccion");
        }

    }

    public static function addNew($eleccion, $profesor){
        $tabla = self::$tabla;
        $return = DB::insert("INSERT INTO $tabla (id_eleccion, cedula_profesor, voto) VALUES ('$eleccion',$profesor, 0)");
        return 1;
    }

    public static function borrar($id_eleccion){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE id_eleccion = '$id_eleccion'");
    }

    public static function getItem($eleccion){
        $tabla = self::$tabla;
        return DB::select("SELECT usuarios.id as cedulas,usuarios.nombre as nombres, pv.id_eleccion as eleccion
                           FROM usuarios, profesores_votantes as pv
                           WHERE pv.id_eleccion = '$eleccion' and
	                       pv.cedula_profesor = usuarios.id");
    }

    public static function editar($id_escuela, $id_eleccion, $cargos){
        return;
    }
}
