<?php

namespace App\Models\Rawpus;

use Illuminate\Database\Eloquent\Model;

class Statusketenagaan extends Model
{
    protected $table="status_ketenagaan";

    public function jabatan(){
        return $this->hasMany('App\Models\Rawpus\Jabatan','status_ketenagaan_id');
    }
}