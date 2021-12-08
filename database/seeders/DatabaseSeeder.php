<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'JuanCarlosCV',
            'nombres' => 'Juan Carlos',
            'apellidos' => 'Casana Vera',
            'dni' => '04532952',
            'sexo' => 'm',
            'edad' => '22',
            'fnac' => '2000-11-09',
            'ncelular' => '996111876',
            'direccion' => 'Lima',
            'profile_photo_path' => 'profile-photos/face.png',
            'email' => 'jcasanav@autonoma.edu.pe',
            'password' => bcrypt('password')
        ]);
        User::factory(10)->create();
    }
}
