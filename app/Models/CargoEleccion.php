<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CargoEleccion extends Model
{
    public $timestamps = true;

    public static $tabla= 'cargos_por_elecciones';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(*) from $tabla");
        return $cantidad[0]->count;
    }

    public static function getCargos(){
        return DB::select("SELECT id, nombre FROM cargos");
    }

    public static function getElecciones(){
        return DB::select('SELECT id FROM proceso_elecciones');
    }

    public static function getEscuelas(){
        return DB::select("SELECT es.id, es.nombre as nombre_escuela, facu.nombre as nombre_facultad, ex.nombre as nombre_extension
                                from escuelas as es, facultades as facu, extensiones as ex
                                WHERE es.id_facultad = facu.id and
                                es.id_extension = ex.id");
    }

    public static function buscar($query){
        $tabla = self::$tabla;
        if(empty($query)){
            return DB::select("SELECT count(ce.id_cargo), elecciones.id as eleccion, escuelas.nombre as escuelas, escuelas.id as id_escuela
                              FROM cargos_por_elecciones as ce, cargos, proceso_elecciones as elecciones, escuelas
                              where
                              ce.id_cargo = cargos.id and
                              ce.id_eleccion = elecciones.id and
                              ce.id_escuela = escuelas.id
                              GROUP BY elecciones.id, escuelas.nombre, escuelas.id");
        }
        else{
            return DB::select("SELECT id, fecha_inicio, fecha_fin FROM $tabla where id = '$query'");
        }
    }

    public static function addNew($eleccion, $cargo, $escuela){
        $tabla = self::$tabla;
        $return = DB::insert("INSERT INTO $tabla (id_cargo, id_eleccion, id_escuela) VALUES ($cargo,'$eleccion', $escuela)");
        return 1;
    }

    public static function borrar($id_escuela,$id_eleccion){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE id_escuela = $id_escuela AND id_eleccion = '$id_eleccion'");
    }

    public static function getItem($id_escuela, $id_eleccion){
        $tabla = self::$tabla;
        return DB::select("SELECT cargos.nombre as cargo, escuelas.nombre, eleccion.id
                        FROM cargos_por_elecciones as ce, cargos, escuelas, proceso_elecciones as eleccion
                        WHERE
                        ce.id_eleccion = '$id_eleccion' and
                        ce.id_escuela = $id_escuela and
                        ce.id_cargo = cargos.id and
                        ce.id_escuela = escuelas.id and
                        eleccion.id = ce.id_eleccion");
    }

    public static function editar($id_escuela, $id_eleccion, $cargos){
        $tabla = self::$tabla;
        self::borrar($id_escuela, $id_eleccion);
        foreach($cargos as $cargo){
            self::addNew($id_eleccion, $cargo, $id_escuela);
        }
        return 1;
    }
}
