<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AngBeton extends Model
{
    protected $table = 'penganggaran_beton';
    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'beton_id', 'penganggaran_id', 'panjang', 'patok_awal', 'patok_akhir', 'lat_awal', 'lng_awal', 'lat_akhir', 'lng_akhir', 'polypath'
    ];

    public function beton()
    {
        return $this->belongsTo('App\Models\Beton', 'beton_id', 'beton_id');
    }

    public function penganggaran()
    {
        return $this->belongsTo('App\Models\Penganggaran', 'penganggaran_id', 'id');
    }
}
