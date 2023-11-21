<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['firstname', 'lastname'];

    protected $dates = ['deleted_at'];

    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class, 'user_hobbies');
    }
}
