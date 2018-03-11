<?php

namespace App\Models\Rawpus;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    protected $table="desa";
    public $incrementing=false;

    public function wilayah(){
        return $this->belongsTo('App\Models\Rawpus\Wilayah','wilayah_id');
    }

    public function pasien(){
        return $this->hasMany('App\Models\Rawpus\Pasien','desa_id');
    }
}