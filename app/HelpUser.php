<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'help_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'views', 'help_id', 'user_id',
    ];
}
