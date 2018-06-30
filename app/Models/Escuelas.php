<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Escuelas extends Model
{
    public $timestamps = true;
    protected $fillable = array(
        'nombre',
        'tipo'
    );

    public static $tabla= 'cargos';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(id) from $tabla");
        return $cantidad[0]->count;
    }

    public static function buscar($query, $tipo = 3){
        $tabla = self::$tabla;
        if(empty($query)){
            return DB::select("select id, nombre from $tabla");
        }
        else{
            if($tipo == 3){
                $result = DB::select("select nombre from $tabla WHERE nombre LIKE '$query%'");
                return $result;
            }
            else{
                $result = DB::select("select nombre from $tabla WHERE nombre LIKE '$query%' and tipo = $tipo");
                return $result;
            }
        }
    }

    public static function addNew($nombre, $tipo){
        $tabla = self::$tabla;
        $return = DB::insert("INSERT INTO $tabla (nombre, tipo) VALUES ('$nombre',$tipo)");
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

    public static function editar($id, $nombre,$tipo){
        $tabla = self::$tabla;
        DB::update("update $tabla set nombre = '$nombre', tipo = $tipo WHERE id = $id");
    }
}
