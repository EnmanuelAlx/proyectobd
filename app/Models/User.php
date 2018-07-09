<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'usuarios';
    protected $fillable = [
        'cedula',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function crearEgresado(array $input){
        $id = $input['id'];
        $nombre = $input['nombre'];
        $direccion =$input['direccion'];
        $password = Hash::make($input['password']);
        $tipo = $input['optionsRadios'];
        $fecha_egreso = $input['fecha_egreso'];
        $estado = $input['estado'];
        $pais = $input['pais'];
        $escuela = $input['escuela'];
        $extension = $input['extension'];
        $foto = '';
        $count = DB::select("SELECT count(id) FROM usuarios where id = '$id'")[0]->count;
        if($count == 1){
            return 0;
        }
        DB::insert("INSERT INTO usuarios (id, nombre, direccion, password, tipo, id_escuela, id_extension, remember_token) VALUES ('$id', '$nombre', '$direccion', '$password', $tipo, $escuela, $extension, '1')");
        DB::insert("INSERT INTO egresados (id, fecha_egreso, estado, pais, foto) VALUES ('$id', '$fecha_egreso', '$estado', '$pais', '$foto')");
        return array(
            'id' => $id,
            'password' => $password
        );
    }

    public static function crearProfesor(array $input){
        $id = $input['id'];
        $nombre = $input['nombre'];
        $direccion =$input['direccion'];
        $password = Hash::make($input['password']);
        $tipo = $input['optionsRadios'];
        $escuela = $input['escuela'];
        $extension = $input['extension'];
        $count = DB::select("SELECT count(id) FROM usuarios where id = '$id'")[0]->count;
        if($count == 1){
            return 0;
        }
        DB::insert("INSERT INTO usuarios (id, nombre, direccion, password, tipo, id_escuela, id_extension, remember_token) VALUES ('$id', '$nombre', '$direccion', '$password', $tipo, $escuela, $extension, '1')");
        DB::insert("INSERT INTO profesores (id) VALUES ('$id')");
        return array(
            'id' => $id,
            'password' => $password
        );
    }


    public static function PuedeAgregar(){
        if(Auth::user()->id == 1){
            return true;
        }
        else if (self::verificarComison(Auth::user()->id)){
            return true;
        }
        return false;
    }

    public static function verificarComison($id){
        $id_eleccion = DB::select("select pe.id 
        from proceso_elecciones as pe
        where (select current_date) between pe.fecha_inicio and pe.fecha_fin")[0]->id;
        $count = DB::select("SELECT count(*) FROM comision_electoral WHERE cedula = $id and id_eleccion = '$id_eleccion'")[0]->count;
        if($count == 1){
            return true;
        }
        return false;
    }

    public static function PuedeEditar(){
        if(Auth::user()->id == 1){
            return true;
        }
        else if (self::verificarComison(Auth::user()->id)){
            return true;
        }
        return false;
    }

//    protected function create(array $data)
//    {
//        return User::create([
//            'name' => $data['name'],
//            'last_name' => $data['last_name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//        ]);
//    }
}
