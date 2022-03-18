<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KursusSesiEnrollment extends Model
{

    protected $guarded = [];
    protected $table = 'kursus_sesi_enrollment';

    public function enrollment() {
      return $this->belongsTo(Enrollment::class, 'id_enrollment', 'id');
    }

  }
