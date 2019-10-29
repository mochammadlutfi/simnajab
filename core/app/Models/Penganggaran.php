<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penganggaran extends Model
{
    protected $table = 'penganggaran';
    protected $primaryKey = 'id';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rute_id', 'tujuan' , 'perusahaan', 'nomor_bast', 'jml_anggaran', 'tgl'
    ];

    public function AngJalan()
    {
        return $this->hasOne('App\Models\AngJalan', 'penganggaran_id', 'id');
    }

    public function jalan()
    {
        return $this->belongsTo('App\Models\Jalan', 'rute_id', 'jalan_id');
    }
}
