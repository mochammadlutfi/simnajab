<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{

    protected $table = 'jalan';
    protected $primaryKey = 'jalan_id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'username' , 'email', 'password',
    ];
}
