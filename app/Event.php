<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
        'responsible_id',
        'company_id',
        'date',
        'text',
        'reminder',
        'views',
        'status'
    ];
}
