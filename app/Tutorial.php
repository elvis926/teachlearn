<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tutorial extends Model
{

    protected $fillable = ['date','hour','observation','topic', 'price','image','duration','subject_id',];
    public static function boot()
    {
        parent::boot();
        static::creating(function ($tutorial) {
            $tutorial->student_id = Auth::id();
            //$tutorial->teacher_id = Auth::id();
        });
    }
    public function student()
    {
        return $this->belongsTo('App\User\student_id');
    }
    public function teacher()
    {
        return $this->belongsTo('App\User\teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

}
