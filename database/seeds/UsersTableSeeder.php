<?php

use App\Subject;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciar la tabla
        User::truncate();
        $faker = \Faker\Factory::create();
        // Crear la misma clave para todos los usuarios
        // conviene hacerlo antes del for para que el seeder
        // no se vuelva lento.
        $password = Hash::make('123123');
        User::create([
            'name' => 'Administrador',
            'last_name' => 'General',
            'birthday' => '1999-02-14',
            'phone' => '0987654321',
            'email' => 'admin@prueba.com',
            'password' => $password,
            //'rol_type' => 'Admin',
            'role'=> User::ROLE_SUPERADMIN,
        ]);
        // Generar algunos usuarios
       // $rol=['teacher','student'];
        $role=['ROLE_STUDENT','ROLE_TEACHER'];
        for ($i = 0; $i < 10; $i++) {
            $user=User::create([
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
                'phone' => $faker-> phoneNumber,
                'email' => $faker->email,
                'password' => $password,
                //'rol_type'=>$faker->randomElement($rol),
                'role'=> $faker->randomElement($role),
            ]);

            $user->subjects()->saveMany(
                $faker->randomElements(
                    array(
                        Subject::find(1),
                        Subject::find(2),
                        Subject::find(3),
                        Subject::find(4),
                        Subject::find(5)
                    ), $faker->numberBetween(1,5),false
                )
            );
        }
    }
}
