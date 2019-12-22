<?php

use Illuminate\Database\Seeder;

class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 0; $i <= 10; $i++){
            
            \DB::table('authors')->insert([
                'name' => $faker->name(),
                'age' => $faker->numberBetween(20, 90),
            ]);
        }
    }
}
