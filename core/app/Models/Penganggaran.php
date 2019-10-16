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
        'jalan_id', 'tujuan' , 'perusahaan', 'nomor_bast', 'jml_anggaran', 'tgl'
    ];


    public function jalan()
    {
        return $this->belongsTo('App\Models\Jalan', 'jalan_id', 'jalan_id');
    }
}
