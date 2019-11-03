<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jembatan extends Model
{
    protected $table = 'jembatan';
    protected $primaryKey = 'jembatan_id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jalan_id', 'kondisi'
    ];

    public function jalan()
    {
        return $this->belongsTo('App\Models\Jalan', 'jalan_id', 'jalan_id');
    }

    public function penganggaran()
    {
        return $this->belongsTo('App\Models\Penganggaran', 'penganggaran_id', 'id');
    }
}
