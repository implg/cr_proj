<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $fillable = [
        'title',
        'created_user',
        'addressee',
        'text'
    ];
}
