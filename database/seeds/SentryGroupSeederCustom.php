<?php

use Illuminate\Database\Seeder;

class SentryGroupSeederCustom extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Менеджеры',
            'permissions' => array(
                'admin' => 0,
                'manager' => 1,
                'supply' => 0,
            )));

        Sentry::getGroupProvider()->create(array(
            'name'        => 'Администраторы',
            'permissions' => array(
                'admin' => 1,
                'manager' => 1,
                'supply' => 1,
            )));
    }
}
