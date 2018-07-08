<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class votacion extends Model
{
    public static function GetEleccionesAct(){
        return DB::select("select pe.id, pe.fecha_inicio,pe.fecha_limite_votacion 
        from proceso_elecciones as pe
        where (select current_date) between pe.fecha_inicio and pe.fecha_fin");     
    }

    public static function GetPostulados($periodo, $tipo, $id_escuela){
        if($tipo == 1){
            return DB::select("SELECT usuarios.nombre, usuarios.id as cedula, sp.n_votos, cargos.nombre as nombre_cargo, ep.id as id_postulado, sp.id_cargos
                           FROM profesores_postulados as ep, posee as sp, cargos, usuarios
                           WHERE sp.id_eleccion = '$periodo' AND 
                           ep.id = sp.id_profesor_postulado AND 
                           sp.id_escuelas = $id_escuela AND 
                           ep.cedula = usuarios.id AND 
                           sp.id_cargos = cargos.id");
        }
        else{
            return DB::select("SELECT usuarios.nombre, usuarios.id as cedula, sp.n_votos, cargos.nombre as nombre_cargo, ep.id as id_postulado, sp.id_cargos
                           FROM egresados_postulados as ep, se_postulan as sp, cargos, usuarios
                           WHERE sp.id_eleccion = '$periodo' AND 
                           ep.id = sp.id_egresado_postulado AND 
                           sp.id_escuelas = $id_escuela AND 
                           ep.cedula = usuarios.id AND 
                           sp.id_cargos = cargos.id");
        }
    }

    public static function validateUser($periodo, $tipo, $cedula){
        if($tipo==1){
            return DB::select("SELECT count(cedula_profesor) FROM profesores_votantes
                               WHERE id_eleccion='$periodo' AND 
                               cedula_profesor = $cedula")[0];
        }
        else{
            return DB::select("SELECT count(cedula_egresado) FROM egresados_votantes
                               WHERE id_eleccion='$periodo' AND 
                               cedula_egresado = $cedula")[0];
        }
    }

    public static function addVoto($id_postulado, $votante, $eleccion, $tipo, $id_cargo){
        if($tipo == 1){
            $votos = DB::select("SELECT n_votos FROM posee WHERE id_profesor_postulado = $id_postulado AND id_eleccion = '$eleccion' AND id_cargos = $id_cargo")[0];
            $n_votos = $votos->n_votos +=1;
            DB::update("UPDATE posee SET n_votos=$n_votos WHERE id_profesor_postulado = $id_postulado AND id_eleccion ='$eleccion' AND id_cargos = $id_cargo");
            DB::update("UPDATE profesores_votantes SET voto = 1 WHERE id_eleccion ='$eleccion' and cedula_profesor = $votante");
            DB::insert("INSERT INTO votos_profesores (id_eleccion, cedula_profesor, id_profesor_postulado)
                        VALUES ('$eleccion', $votante, $id_postulado)");
        }else{
            $votos = DB::select("SELECT n_votos FROM se_postulan WHERE id_egresado_postulado = $id_postulado AND id_eleccion = '$eleccion' AND id_cargos = $id_cargo")[0];
            $n_votos = $votos->n_votos +=1;
            DB::update("UPDATE se_postulan SET n_votos=$n_votos WHERE id_egresado_postulado = $id_postulado AND id_eleccion ='$eleccion' AND id_cargos = $id_cargo");
            DB::update("UPDATE egresados_votantes SET voto = 1 WHERE id_eleccion ='$eleccion' and cedula_egresado = $votante");
            DB::insert("INSERT INTO votos_egresados (id_eleccion, cedula_egresado, id_egresado_postulado)
                        VALUES ('$eleccion', $votante, $id_postulado)");
        }
    }

    public static function validateVoto($periodo, $tipo, $cedula){
        if($tipo == 1){
            return DB::select("SELECT count(*) FROM votos_profesores WHERE cedula_profesor = $cedula AND id_eleccion = '$periodo'")[0]->count;
        }else{
            return DB::select("SELECT count(*) FROM votos_egresados WHERE cedula_egresado = $cedula AND id_eleccion = '$periodo'")[0]->count;
        }
    }
}

