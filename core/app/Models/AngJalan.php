<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AngJalan extends Model
{
    protected $table = 'penganggaran_jalan';
    // protected $primaryKey = '_id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'jalan_id', 'penganggaran_id', 'panjang', 'patok_awal', 'patok_akhir', 'lat_awal', 'lng_awal', 'lat_akhir', 'lng_akhir', 'polypath'
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
