<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{

    use SoftDeletes;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'about',
        'image',
        'fb',
        'tw',
        'linked',
        'user_id',
        'nik',
        'tgl_lahir',
        'dtks',
        'is_disable',
        'id_provinsi',
        'id_kota',
        'id_kecamatan',
        'id_kelurahan',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'id_provinsi');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'id_kota');
    }

    public function subdistrict()
    {
        return $this->belongsTo(Subdistrict::class, 'id_kecamatan');
    }

    public function urbanVillage()
    {
        return $this->belongsTo(UrbanVillage::class, 'id_kelurahan');
    }
}

