<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'group_id',
        'name',
        'status',
        'phone_accountant',
        'phones',
        'director',
        'address_legal',
        'address_physical',
        'city',
        'site',
        'employee',
        'email',
        'isq',
        'skype',
        'facebook',
        'vk',
        'postcode',
        'okpo',
        'inn',
        'num_certificate'
    ];
}
