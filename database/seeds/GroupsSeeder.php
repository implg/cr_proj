<?php

use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups_company')->insert([
            'name' => 'Поставщик'
        ]);

        DB::table('groups_company')->insert([
            'name' => 'Покупатель'
        ]);
    }
}
