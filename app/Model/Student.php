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
}
