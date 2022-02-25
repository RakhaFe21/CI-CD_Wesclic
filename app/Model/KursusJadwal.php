<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KursusJadwal extends Model
{

    protected $guarded = [];
    protected $table = 'kursus_jadwal';

    public function sesi()
    {
    	return $this->hasMany('App\Model\KursusSesi','id_kursus_jadwal','id');
    }

  }
