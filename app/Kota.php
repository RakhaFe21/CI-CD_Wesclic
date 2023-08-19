<?php

// app/Models/City.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $fillable = [
        'nama_kota',
        'id_provinsi',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'id_kota');
    }

    public function provinsi()
    {
        return $this->belongsTo(Province::class, 'id_provinsi');
    }
}
