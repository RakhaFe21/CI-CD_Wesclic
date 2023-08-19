<?php

// app/Models/Subdistrict.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $fillable = [
        'nama_kecamatan',
        'id_kota',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'id_kecamatan');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'id_kota');
    }
}

