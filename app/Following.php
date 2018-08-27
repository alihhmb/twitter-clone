<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    protected $table = "following";

    protected $fillable = [
        'user_id', 'followed_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function followed()
    {
        return $this->belongsTo(User::class);
    }

}
