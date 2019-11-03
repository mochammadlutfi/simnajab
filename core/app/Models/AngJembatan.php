<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AngJembatan extends Model
{
    protected $table = 'penganggaran_jembatan';
    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jembatan_id', 'penganggaran_id'
    ];

    public function jembatan()
    {
        return $this->belongsTo('App\Models\Jembatan', 'jembatan_id', 'jembatan_id');
    }

    public function penganggaran()
    {
        return $this->belongsTo('App\Models\Penganggaran', 'penganggaran_id', 'id');
    }
}
