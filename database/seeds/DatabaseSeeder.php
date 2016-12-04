<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        DB::table('people')->insert([
            'name'     => $faker->name,
            'email'    => $faker->email,
        ]);
        DB::table('people')->insert([
            'name'     => $faker->name,
            'email'    => $faker->email,
        ]);

        DB::table('chats')->insert([
            'active'     => true,
        ]);
        DB::table('chat_messages')->insert([
            'chat_id'     => 1,
            'person_id' => 1,
            'message' => $faker->sentence
        ]);
        DB::table('chat_messages')->insert([
            'chat_id'     => 1,
            'person_id' => 2,
            'message' => $faker->sentence
        ]);
        DB::table('chat_messages')->insert([
            'chat_id'     => 1,
            'person_id' => 2,
            'message' => $faker->sentence
        ]);
        DB::table('chat_messages')->insert([
            'chat_id'     => 1,
            'person_id' => 1,
            'message' => $faker->sentence
        ]);

    }
}
