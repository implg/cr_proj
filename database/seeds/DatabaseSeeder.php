<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SentryUserSeederCustom::class);
        $this->call(SentryGroupSeederCustom::class);
        $this->call(SentryUserGroupSeederCustom::class);
        $this->call(GroupsSeeder::class);
    }
}
