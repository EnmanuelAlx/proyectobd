<?php
/**
 * Created by PhpStorm.
 * User: Enmanuel
 * Date: 27/06/2018
 * Time: 10:28
 */
class UserTableSeeder extends Seeder {
    public function run(){
        User::create(array(
            'cedula' => '123',
            'nombre'  => 'Admin',
            'direccion'     => 'Venezuela',
            'password' => Hash::make('admin'), // Hash::make() nos va generar una cadena con nuestra contraseña encriptada,
            'tipo' => 0
        ));
    }
}