<?php

namespace App\Models\Rawpus;

use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    protected $table="pelayanan";
    
    public $incrementing=false;

    public function pasien(){
        return $this->belongsTo('App\Models\Rawpus\Pasien','no_kartu','no_kartu');
    }

    public function pelayanan(){
        return $this->hasOne('App\Models\Rawpus\Pelayanan','no_pendaftaran_atau_kartu','no_pendaftaran');
    }

    public function diagnosa(){
        return $this->belongsTo('App\Models\Rawpus\Diagnosa','diagnosa_id');
    }
}