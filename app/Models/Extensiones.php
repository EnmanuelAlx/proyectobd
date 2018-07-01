<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Extensiones extends Model
{
	public $timestamps = true;

    public static $tabla= 'extensiones';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(id) from $tabla");
        return $cantidad[0]->count;
    }


    public static function buscar($query,$nombre){
        $tabla = self::$tabla;
        if(empty($query)){
            return DB::select("select id, nombre from $tabla");
        }
        else{
            return DB::select(" SELECT id, nombre FROM $tabla where nombre LIKE '$query%' ");
        }
    }

    public static function addNew($nombre){
        $tabla = self::$tabla;
        $return = DB::insert("INSERT INTO $tabla (nombre) VALUES ('$nombre')");
        return 1;
    }

    public static function borrar($id){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE id = $id");
    }

    public static function getItem($id){
        $tabla = self::$tabla;
        return DB::select("SELECT * from $tabla WHERE id = $id")[0];
    }

    public static function editar($id, $nombre){
        $tabla = self::$tabla;
        DB::update("update $tabla set nombre = '$nombre' WHERE id = $id ");
   }
}
