<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TPT extends Model
{
    protected $table = 'tpt';
    protected $primaryKey = 'tpt_id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jalan_id', 'pasang_batu' , 'beton', 'kondisi', 'posisi'
    ];


    public function jalan()
    {
        return $this->belongsTo('App\Models\Jalan', 'jalan_id', 'jalan_id');
    }
}
