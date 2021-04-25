<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Book  extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        "ISBN",
        "title",
        "author",
        "editorial",
        "gender",
        "user_id",
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
}
