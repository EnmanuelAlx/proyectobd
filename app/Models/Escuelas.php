<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Escuelas extends Model
{
    public $timestamps = true;
    
    public static $tabla= 'escuelas';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(id) from $tabla");
        return $cantidad[0]->count;
    }

    public static function getFacultades(){
        return DB::select("SELECT id, nombre FROM facultades");
    }

    public static function getExtensiones(){
        return DB::select("SELECT id, nombre FROM extensiones");
    }

    public static function buscar($query){
        $tabla = self::$tabla;
        if(empty($query)){
            return DB::select("SELECT es.id, es.nombre as nombre_escuela, facu.nombre as nombre_facultad, ex.nombre as nombre_extension
                                from escuelas as es, facultades as facu, extensiones as ex
                                WHERE es.id_facultad = facu.id and
                                es.id_extension = ex.id");
        }
        else{
            return DB::select("SELECT es.id, es.nombre as nombre_escuela, facu.nombre as nombre_facultad, ex.nombre as extension_facultad
                                from escuelas as es, facultades as facu, extensiones as ex
                                WHERE es.nombre LIKE '$query%' AND 
                                es.id_facultad = facu.id and
                                es.id_extension = ex.id");
        }

    }

    public static function addNew($nombre,$id_facultad,$id_extension){
        $tabla = self::$tabla;
        $return = DB::insert("INSERT INTO $tabla (nombre,id_facultad,id_extension) VALUES ('$nombre',$id_facultad,$id_extension)");
        return 1;
    }

    public static function borrar($id){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE id = $id");
    }

    public static function getItem($id){
        $tabla = self::$tabla;
        return DB::select("SELECT es.id, es.nombre as nombre_escuela, facu.nombre as nombre_facultad, ex.nombre as nombre_extension
                                from escuelas as es, facultades as facu, extensiones as ex
                                WHERE es.id = $id and
                                es.id_facultad = facu.id and
                                es.id_extension = ex.id")[0];
    }

    public static function editar($id, $nombre,$facultad,$extension){
        $tabla = self::$tabla;
        DB::update("UPDATE $tabla SET nombre='$nombre',id_facultad=$facultad ,id_extension=$extension WHERE id = $id");
    }
}
