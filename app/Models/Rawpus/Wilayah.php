<?php

namespace App\Models\Rawpus;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table="wilayah";
    public $incrementing=false;

    public function desa(){
        return $this->hasMany('App\Models\Rawpus\Desa','wilayah_id');
    }
}