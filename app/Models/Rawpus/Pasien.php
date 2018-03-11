<?php

namespace App\Models\Rawpus;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table="pasien";

    public function desa(){
        return $this->belongsTo('App\Models\Rawpus\Desa','desa_id')
            ->select(
                [
                    'id',
                    'name'
                ]
            );
    }
}