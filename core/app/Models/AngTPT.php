<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AngTPT extends Model
{
    protected $table = 'penganggaran_tpt';
    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tpt_id', 'penganggaran_id', 'panjang', 'patok_awal', 'patok_akhir', 'lat_awal', 'lng_awal', 'lat_akhir', 'lng_akhir', 'polypath'
    ];

    public function drainase()
    {
        return $this->belongsTo('App\Models\Drainase', 'drainase_id', 'drainase_id');
    }

    public function penganggaran()
    {
        return $this->belongsTo('App\Models\Penganggaran', 'penganggaran_id', 'id');
    }
}
