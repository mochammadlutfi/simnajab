<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NJOP extends Model
{
    protected $table = 'njop';
    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jalan_id', 'jml_anggaran', 'tgl'
    ];

    public function jalan()
    {
        return $this->belongsTo('App\Models\Jalan', 'jalan_id', 'jalan_id');
    }
}
