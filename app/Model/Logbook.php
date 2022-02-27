<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $table = 'logbook';
    protected $primaryKey = 'id';

    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

}