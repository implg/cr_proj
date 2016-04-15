<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('branch_id');
            $table->string('name');
            $table->integer('status');
            $table->string('phone_accountant');
            $table->string('phones');
            $table->string('city');
            $table->string('director');
            $table->string('site');
            $table->string('employee');
            $table->string('email');
            $table->string('isq');
            $table->string('skype');
            $table->string('facebook');
            $table->string('vk');
            $table->string('postcode');
            $table->text('address_legal');
            $table->text('address_physical');
            $table->text('okpo');
            $table->text('inn');
            $table->text('num_certificate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('company');
    }
}
