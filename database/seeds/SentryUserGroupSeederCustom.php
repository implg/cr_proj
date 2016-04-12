<?php

use Illuminate\Database\Seeder;

class SentryUserGroupSeederCustom extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_groups')->delete();

        $userUser = Sentry::getUserProvider()->findByLogin('user@user.com');
        $adminUser = Sentry::getUserProvider()->findByLogin('admin@admin.com');

        $userGroup = Sentry::getGroupProvider()->findByName('Менеджеры');
        $adminGroup = Sentry::getGroupProvider()->findByName('Администраторы');


        // Assign the groups to the users
        $userUser->addGroup($userGroup);
        $adminUser->addGroup($userGroup);
        $adminUser->addGroup($adminGroup);
    }
}
