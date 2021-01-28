<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $fillable = ['text','user_id'];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($comment) {
            $comment->user_id = Auth::id();
        });
    }

    public function users(){
        return $this->belongsTo('App\User');
    }

}


