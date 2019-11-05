<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drainase extends Model
{
    protected $table = 'drainase';
    protected $primaryKey = 'drainase_id';

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

    public function penganggaran()
    {
        return $this->belongsTo('App\Models\Penganggaran', 'penganggaran_id', 'id');
    }
}
