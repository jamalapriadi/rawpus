<?php

namespace App\Models\Rawpus;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table="jabatan";

    public function status(){
        return $this->belongsTo('App\Models\Rawpus\Statusketenagaan','status_ketenagaan_id');
    }

    public function tenagamedis(){
        return $this->hasMany('App\Models\Rawpus\Tenagamedis','jabatan_id');
    }
}