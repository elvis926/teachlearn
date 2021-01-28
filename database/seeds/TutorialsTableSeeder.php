<?php

use App\Tutorial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class TutorialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vaciar la tabla
        Tutorial::truncate();
        $faker = \Faker\Factory::create();
        // Crear la misma clave para todos los usuarios
        // conviene hacerlo antes del for para que el seeder
        // no se vuelva lento.
        // Generar algunos tutorias


        //$student = App\User::all($role=['ROLE_STUDENT']);
        //$student = App\User::all($user=['ROLE_STUDENT']);
        $students = DB::table('users')->where('role', 'ROLE_STUDENT')->get(
            [
                'id',
                'email',
                'password'
            ]);
        $teachers = DB::table('users')->where('role', 'ROLE_TEACHER')->get(
            [
                'id',
                'email',
                'password'
            ]);
        //$teacher = App\User::all($role=['ROLE_TEACHER']);
        $subjects=App\Subject::all();

        foreach ($students as $user) {
            // iniciamos sesión con este usuario
            JWTAuth::attempt(['email' => $user->email, 'password' => '123123']);
            $num_tutorials=3;
            $image_name=$faker->image('public/storage/tutorials',400,250,null,false);
            for ($i = 0; $i < $num_tutorials; $i++) {
                $subject=$faker->randomElement($subjects);
                $teacher=$faker->randomElement($teachers);

                Tutorial::create([
                    'date' => $faker->dateTime()->format('Y-m-d'),
                    'hour' => $faker->time($format = 'H:i:s'),
                    'price' => '10',
                    'observation' => $faker->sentence,
                    'topic' => $faker->sentence,
                    'image' => 'tutorials/'. $image_name,
                    'duration' => '1',
                    'subject_id'=>$subject->id,
                    'teacher_id'=>$teacher->id,
                ]);
            }
        }

    }
}
