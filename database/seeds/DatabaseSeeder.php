<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('roles')->insert([
            'name' => 'admin',
        ]);
        DB::table('roles')->insert([
            'name' => 'user',
        ]);
        DB::table('roles')->insert([
            'name' => 'company',
        ]);
        DB::table('roles')->insert([
            'name' => 'deliveryMan',
        ]);

        DB::statement("SET foreign_key_checks = 0");
        $this->call(BrandSeeder::class);
    }
}
