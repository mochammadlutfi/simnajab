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

    public function jembatan()
    {
        return $this->hasOne('App\Models\Jembatan', 'penganggaran_id', 'id');
    }

    public function AngJembatan()
    {
        return $this->hasOne('App\Models\AngJembatan', 'penganggaran_id', 'id');
    }

    public function tpt()
    {
        return $this->hasOne('App\Models\TPT', 'penganggaran_id', 'id');
    }

    public function AngTPT()
    {
        return $this->hasOne('App\Models\AngTPT', 'penganggaran_id', 'id');
    }

    public function drainase()
    {
        return $this->hasOne('App\Models\Drainase', 'penganggaran_id', 'id');
    }

    public function AngDrainase()
    {
        return $this->hasOne('App\Models\AngDrainase', 'penganggaran_id', 'id');
    }

    public function beton()
    {
        return $this->hasOne('App\Models\Beton', 'penganggaran_id', 'id');
    }

    public function AngBeton()
    {
        return $this->hasOne('App\Models\AngBeton', 'penganggaran_id', 'id');
    }

    public function jalan()
    {
        return $this->belongsTo('App\Models\Jalan', 'rute_id', 'jalan_id');
    }
}
