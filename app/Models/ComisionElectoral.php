<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ComisionElectoral extends Model
{
    public static $tabla= 'comision_electoral';


    public static function cantidad(){
        $tabla = self::$tabla;
        $cantidad = DB::select("select count(*) from $tabla");
        return $cantidad[0]->count;
    }

    public static function getEgresados(){
        return DB::select("SELECT usuarios.nombre as egresado_nombre, usuarios.id as egresado_id
                           FROM usuarios, egresados
                           WHERE egresados.id = usuarios.id");
    }

    public static function getProfesores(){
        return DB::select("SELECT usuarios.nombre as profesor_nombre, usuarios.id as profesor_id
                           FROM usuarios
                           INNER JOIN profesores 
                           ON usuarios.id = profesores.id");
    }


    public static function buscar($query){
        $tabla = self::$tabla;
        if(empty($query)){
            return DB::select("select usuarios.nombre, cedula, id_eleccion from $tabla
                               INNER JOIN usuarios on $tabla.cedula = usuarios.id");
        }
        else{
            return DB::select(" SELECT id, nombre FROM $tabla where nombre LIKE '$query%' ");
        }
    }

    public static function addNew($eleccion, $usuarios){
        $tabla = self::$tabla;
        foreach($usuarios as $usuario){
            DB::insert("INSERT INTO $tabla (cedula, id_eleccion) VALUES ($usuario, '$eleccion')");
        }
        return 1;
    }

    public static function borrar($cedula, $eleccion){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE cedula = $cedula and id_eleccion = '$eleccion'");
    }

    public static function getItem($cedula, $eleccion){
        $tabla = self::$tabla;
        return DB::select("SELECT *, usuarios.nombre, escuelas.nombre as nombre_escuela from $tabla 
                           INNER JOIN usuarios on $tabla.cedula = usuarios.id
                           INNER JOIN escuelas on usuarios.id_escuela = escuelas.id
                           WHERE cedula = $cedula and id_eleccion = '$eleccion'")[0];
    }

    public static function editar($eleccion, $usuarios){
        $tabla = self::$tabla;
        DB::delete("DELETE FROM $tabla WHERE id_eleccion = '$eleccion'");
        foreach ($usuarios as $usuario) {
            DB::insert("INSERT INTO $tabla (cedula, id_eleccion) VALUES ($usuario, '$eleccion')");
        }
        return 1;
    }
}
