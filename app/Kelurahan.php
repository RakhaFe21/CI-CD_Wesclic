<?php

// app/Models/UrbanVillage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $fillable = [
        'nama_kelurahan',
        'id_kecamatan',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'id_kelurahan');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }
}

