<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $this->call(SubjectsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TutorialsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        Schema::enableForeignKeyConstraints();
    }
}
