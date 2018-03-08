<?php

namespace App\Models\Rawpus;

use Illuminate\Database\Eloquent\Model;

class Tenagamedis extends Model
{
    protected $table="tenaga_medis";

    public function jabatan(){
        return $this->belongsTo('App\Models\Rawpus\Jabatan','jabatan_id');
    }
}