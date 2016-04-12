<?php

use Illuminate\Database\Seeder;

class SentryUserSeederCustom extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        Sentry::getUserProvider()->create(array(
            'email'    => 'admin@admin.com',
            'username' => 'admin',
            'password' => '123456',
            'activated' => 1,
        ));

        Sentry::getUserProvider()->create(array(
            'email'    => 'user@user.com',
            'username' => 'user',
            'password' => '123456',
            'activated' => 1,
        ));
    }
}
