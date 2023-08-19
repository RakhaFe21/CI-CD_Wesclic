<?php

// app/Models/Province.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $fillable = [
        'nama_provinsi',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'id_provinsi');
    }
}

