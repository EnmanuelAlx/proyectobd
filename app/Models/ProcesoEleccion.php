<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProcesoEleccion extends Model
{
    public $timestamps = true;

    public static $tabla= 'proceso_elecciones';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(id) from $tabla");
        return $cantidad[0]->count;
    }


    public static function buscar($query){
        $tabla = self::$tabla;
        if(empty($query)){
            return DB::select("select id, fecha_inicio, fecha_fin from $tabla");
        }
        else{
            return DB::select("SELECT id, fecha_inicio, fecha_fin FROM $tabla where id = '$query'");
        }
    }

    public static function addNew($id, $fecha_inicio, $fecha_fin, $fecha_limite_postulacion, $fecha_limite_votacion){
        $tabla = self::$tabla;
        $return = DB::insert("INSERT INTO $tabla (id, fecha_inicio, fecha_fin, fecha_limite_postulacion, fecha_limite_votacion) VALUES ('$id','$fecha_inicio','$fecha_fin', '$fecha_limite_postulacion', '$fecha_limite_votacion')");
        return 1;
    }

    public static function borrar($id){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE id = '$id'");
    }

    public static function getItem($id){
        $tabla = self::$tabla;
        return DB::select("SELECT * from $tabla WHERE id = '$id'")[0];
    }

    public static function editar($id, $f_inicio, $f_fin, $fecha_limite_postulacion, $fecha_limite_votacion){
        $tabla = self::$tabla;
        DB::update("update $tabla set fecha_inicio = '$f_inicio', fecha_fin = '$f_fin', fecha_limite_postulacion = '$fecha_limite_postulacion', fecha_limite_votacion = '$fecha_limite_votacion' WHERE id = '$id'");
    }

    public static function getEleccion($id){
        $tabla = self::$tabla;
        return DB::select("SELECT * FROM $tabla where id = '$id'");
    }
}
