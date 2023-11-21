<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserHobby extends Model
{
    protected $fillable = ['users_id', 'hobby_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hobby()
    {
        return $this->belongsTo(Hobby::class);
    }
}
