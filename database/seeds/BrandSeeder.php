<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->truncate();
        DB::table('brands')->insert(array (
            0 =>
                [
                    'id' => 1,
                    'name' => 'Oui',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            1 =>
                [
                    'id' => 2,
                    'name' => 'Riani',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            2 =>
                [
                    'id' => 4,
                    'name' => 'Calvin Klein',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            3 =>
                [
                    'id' =>5,
                    'name' => 'Miss Via',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],


        ));
    }
}
